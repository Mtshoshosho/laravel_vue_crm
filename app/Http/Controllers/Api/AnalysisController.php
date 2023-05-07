<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Services\AnalysisService;
use App\Services\DecileService;




class AnalysisController extends Controller
{
    // フォームに入力された値は(Request $request)で受け取れる
    public function index(Request $request)
    {
        //期間指定
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        // 日付ごとの売上を取得
        if ($request->type === 'perDay') {
            // listでAnalysisServiceのperdayメソッドを呼び出す
            [$data, $labels, $totals] = AnalysisService::perDay($subQuery);
        }
        // 月毎の売上を取得
        if ($request->type === 'perMonth') {
            // listでAnalysisServiceのperdayメソッドを呼び出す
            [$data, $labels, $totals] = AnalysisService::perMonth($subQuery);
        }
        // 年ごとの売上を取得
        if ($request->type === 'perYear') {
            // listでAnalysisServiceのperdayメソッドを呼び出す
            [$data, $labels, $totals] = AnalysisService::perYear($subQuery);
        }
        // 年ごとの売上を取得
        if ($request->type === 'decile') {
            // listでDecileServiceのperdayメソッドを呼び出す
            [$data, $labels, $totals] = DecileService::decile($subQuery);
        }
        // Ajax通信なのでJsonで返却する必要がある 
        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals,

        ], Response::HTTP_OK);
    }
}
