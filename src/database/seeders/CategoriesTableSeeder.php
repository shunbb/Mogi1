<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'ファッション'],
            ['name' => '家電・カメラ'],
            ['name' => 'インテリア・住まい'],
            ['name' => 'レディース'],
            ['name' => 'メンズ'],
            ['name' => 'コスメ・美容'],
            ['name' => '本・雑誌'],
            ['name' => 'おもちゃ・ホビー'],
            ['name' => 'スポーツ・レジャー'],
            ['name' => 'ハンドメイド'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}