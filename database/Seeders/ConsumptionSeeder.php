<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Consumption;

class ConsumptionSeeder extends Seeder
{
    public function run()
    {
        Consumption::insert([
            [
                'id' => '1',
                'code' => 'RKK/2021/00001',
                'code_quotation' => 'Q2021-00001',
                'customer' => 'BELK',
                'customer_style' => 'BELK-SPRING',
                'number_mp' => 'MCP/21/00001',
                'size_tengah' => '',
                'delivery_date' => '2021-03-04',
                'references_date' => '2021-03-04',
                'net_price' => '6',
                'status' => 'PENDING',
            ]
        ]);
    }
}
