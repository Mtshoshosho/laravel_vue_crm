<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertiaTest;

class InertiaTestController extends Controller
{
    //メソッドの記載
    public function index()
    {
        // データのリスト表示
        return Inertia::render('Inertia/Index', [
            'blogs' => InertiaTest::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Inertia/Create');
    }

    public function show($id)
    {
        return Inertia::render('Inertia/Show', [
            'id' => $id,
            'blog' => InertiaTest::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required']
        ]);

        // データベース
        $inertiaTest = new InertiaTest;
        $inertiaTest->title = $request->title;
        $inertiaTest->content = $request->content;
        $inertiaTest->save();

        // フラッシュメッセージ
        return to_route('inertia.index')
        ->with([
            'message' => '登録しました'
        ]);
    }

    public function delete($id)
    {
        // 削除機能
        $blog = InertiaTest::findOrFail($id);
        $blog->delete();
        
        // フラッシュメッセージ
        return to_route('inertia.index')
        ->with([
            'message' => '削除しました。'
        ]);
    }
}
