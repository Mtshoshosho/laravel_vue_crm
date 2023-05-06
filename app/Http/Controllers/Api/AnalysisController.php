<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class AnalysisController extends Controller
{
    // フォームに入力された値は(Request $request)で受け取れる
    public function index(Request $request)
    {
        //期間指定
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        //
        if ($request->type === 'perDay') {
            $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, 
            DATE_FORMAT(created_at, "%Y%m%d") AS date');

            $data = DB::table($subQuery)
                ->groupBy('date')
                ->selectRaw('date, sum(totalPerPurchase) as total')
                ->get();

            // plackでデータから必要な情報を引っ張る
            $labels = $data->pluck('date');
            $totals = $data->pluck('total');

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
