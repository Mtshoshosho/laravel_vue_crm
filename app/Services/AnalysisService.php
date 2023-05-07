<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;

class AnalysisService
{
    public static function perDay($subQuery)
    {
        $query = $subQuery->where('status', true)
        ->groupBy('id')
        ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, 
        DATE_FORMAT(created_at, "%Y%m%d") AS date');

        // $queryとして実行した処理を$dataに格納
        $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        // plackでデータから必要な情報を引っ張る
        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return [$data, $labels, $totals];
    }
    public static function perMonth($subQuery)
    {
        $query = $subQuery->where('status', true)
        ->groupBy('id')
        ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, 
        DATE_FORMAT(created_at, "%Y%m") AS date');

        // $queryとして実行した処理を$dataに格納
        $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        // plackでデータから必要な情報を引っ張る
        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return [$data, $labels, $totals];
    }
    public static function perYear($subQuery)
    {
        $query = $subQuery->where('status', true)
        ->groupBy('id')
        ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, 
        DATE_FORMAT(created_at, "%Y") AS date');

        // $queryとして実行した処理を$dataに格納
        $data = DB::table($query)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        // plackでデータから必要な情報を引っ張る
        $labels = $data->pluck('date');
        $totals = $data->pluck('total');

        return [$data, $labels, $totals];
    }

    
}