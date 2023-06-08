<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies')->insert([
            [
                'id' => '10',
                'company_name' => 'コカ・コーラ',
                'street_address' => '千代田区',
                'representative_name' => '松尾',
            ],
            [
                'id' => '20',
                'company_name' => '伊藤園',
                'street_address' => '墨田区',
                'representative_name' => '角谷',
            ],
            [
                'id' => '30',
                'company_name' => 'アサヒ',
                'street_address' => '江南区',
                'representative_name' => '小泉',
            ],
        ]);
    }
}
