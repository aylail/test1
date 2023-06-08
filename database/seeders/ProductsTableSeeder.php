<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->insert([
            [
                'id' => '10',
                'company_id' => '1',
                'product_name' => 'コーラ',
                'price' => '120',
                'stock' => '1',
                'comment' => 'コカ・コーラ',
            ],
            [
                'id' => '20',
                'company_id' => '2',
                'product_name' => 'お茶',
                'price' => '10',
                'stock' => '20',
                'comment' => '伊藤園',
            ],
            [
                'id' => '30',
                'company_id' => '3',
                'product_name' => 'ビール',
                'price' => '200',
                'stock' => '3',
                'comment' => 'アサヒ',
            ],
            [
                'id' => '40',
                'company_id' => '4',
                'product_name' => 'サイダー',
                'price' => '200',
                'stock' => '3',
                'comment' => 'キリン',
            ],   [
                'id' => '50',
                'company_id' =>'5',
                'product_name' => '黒ラベル',
                'price' => '200',
                'stock' => '3',
                'comment' => 'サッポロ',
            ],
        ]);
    }
}
