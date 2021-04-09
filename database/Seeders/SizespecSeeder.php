<?php

namespace Database\Seeders;

use App\Sizespec;
use Illuminate\Database\Seeder;

class SizespecSeeder extends Seeder
{
    public function run()
    {
        Sizespec::insert([
            [
                'id' => '1',
                'id_sales_sample' => '1',
                'id_size' => '1',
                'specification' => 'chest',
                'allowance' => '1',
                'position' => '2',
                'unit' => 'CM',
                'value' => '10'
            ],
            [
                'id' => '2',
                'id_sales_sample' => '1',
                'id_size' => '2',
                'specification' => 'shoulder',
                'allowance' => '2',
                'position' => '2',
                'unit' => 'CM',
                'value' => '20'
            ]
        ]);
    }
}
