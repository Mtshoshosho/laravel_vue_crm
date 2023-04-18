<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// ファサードを読み込む
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 作るダミーデータの情報
        DB::table('items')->insert([
            [
                'name' => 'カット',
                'memo' => 'カット詳細',
                'price' => 6000
            ],
            [
                'name' => 'カラー',
                'memo' => 'カラー詳細',
                'price' => 8000
            ],
            [
                'name' => 'パーマ(カット込み)',
                'memo' => 'パーマ詳細',
                'price' => 13000
            ],
        ]);
    }
}
