<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Sizes;

class SizesSeeder extends Seeder
{
    public function run()
    {
        Sizes::insert([
            [
                'id' => 1,
                'name' => 'M',
                'weight' => 0,
                'status' => 'true'
            ], [
                'id' => 2,
                'name' => 'L',
                'weight' => 0,
                'status' => 'true'
            ], [
                'id' => 3,
                'name' => 'XL',
                'weight' => 0,
                'status' => 'true'
            ]
        ]);
    }
}
