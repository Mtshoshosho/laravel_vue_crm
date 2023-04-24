<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// ファサードを読み込む
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// ここの名称をファイル名と揃える
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 作るダミーデータの情報
        DB::table('users')->insert([
        'name' => 'ヤマモト',
        'email' => '1225@gmail.com',
        'password' => Hash::make('pass1225')
        ]);
    }
}
