<?php

use Illuminate\Database\Seeder;
use App\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        Brand::insert([
            [
                'id' => '1',
                'name' => 'sun-valley'
            ], [
                'id' => '2',
                'name' => 'macys'
            ], [
                'id' => '3',
                'name' => 'BELK'
            ]
        ]);
    }
}
