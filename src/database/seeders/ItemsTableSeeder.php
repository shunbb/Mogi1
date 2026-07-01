<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('users')->insertGetId([
            'name' => '吉本太郎',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('profiles')->insert([
            'user_id' => $userId,
            'img_url' => 'https://via.placeholder.com/150',
            'postal_code' => '160-0022',
            'address' => '東京都新宿区新宿5丁目18番21号',
            'building' => '旧新宿区四谷第五小学校',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $items = [
            ['name' => '腕時計', 'price' => 15000, 'brand' => 'Rolex', 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'condition' => '良好'],
            ['name' => 'HDD', 'price' => 5000, 'brand' => '西芝', 'description' => '高速で信憑性の高いハードディスク', 'condition' => '目立った傷や汚れなし'],
            ['name' => '玉ねぎ3束', 'price' => 300, 'brand' => 'なし', 'description' => '新鮮な玉ねぎ3束のセット', 'condition' => 'やや傷や汚れあり'],
            ['name' => '革靴', 'price' => 4000, 'brand' => 'なし', 'description' => 'クラシックなデザインの革靴', 'condition' => '状態が悪い'],
            ['name' => 'ノートPC', 'price' => 45000, 'brand' => 'なし', 'description' => '高性能なノートパソコン', 'condition' => '良好'],
            ['name' => 'マイク', 'price' => 8000, 'brand' => 'なし', 'description' => '高音質のレコーディング用マイク', 'condition' => '目立った傷や汚れなし'],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'brand' => 'なし', 'description' => 'おしゃれなショルダーバッグ', 'condition' => 'やや傷や汚れあり'],
            ['name' => 'タンブラー', 'price' => 500, 'brand' => 'なし', 'description' => '使いやすいタンブラー', 'condition' => '状態が悪い'],
            ['name' => 'コーヒーミル', 'price' => 4000, 'brand' => 'Starbacks', 'description' => '手動のコーヒーミル', 'condition' => '良好'],
            ['name' => 'メイクセット', 'price' => 2500, 'brand' => 'なし', 'description' => '便利なメイクアップセット', 'condition' => '目立った傷や汚れなし'],
        ];

        foreach ($items as $index => $item) {
            $itemId = DB::table('items')->insertGetId([
                'user_id' => $userId,
                'name' => $item['name'],
                'price' => $item['price'],
                'brand' => $item['brand'],
                'description' => $item['description'],
                'img_url' => 'https://via.placeholder.com/300', // 仮の画像URL
                'condition' => $item['condition'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('item_category')->insert([
                'item_id' => $itemId,
                'category_id' => ($index % 10) + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}