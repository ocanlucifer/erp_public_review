<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Assortment;

class AssortmentSeeder extends Seeder
{
    public function run()
    {
        Assortment::insert([
            [
                'id' => 1,
                'id_sales_sample' => 1,
                'id_size' => 1,
                'id_color' => 2,
                'quantity' => 1,
                'tolerance' => 0
            ],
            [
                'id' => 2,
                'id_sales_sample' => 1,
                'id_size' => 2,
                'id_color' => 1,
                'quantity' => 1,
                'tolerance' => 0
            ]
        ]);
    }
}
