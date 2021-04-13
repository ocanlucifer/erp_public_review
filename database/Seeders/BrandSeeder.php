<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
