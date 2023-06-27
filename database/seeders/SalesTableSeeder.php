<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sales')->insert([
            [
                'id' => '10',
                'product_id' => '1111',  
            ],
            [
                'id' => '20',
                'product_id' => '2222',  
            ],
            [
                'id' => '30',
                'product_id' => '3333',  
            ],

        ]);
    }
}

