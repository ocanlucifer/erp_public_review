<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColorSeeder extends Seeder
{
    public function run()
    {
        Color::insert(
            [
                'id' => 1,
                'name' => 'coral'
            ],
            [
                'id' => 2,
                'name' => 'emerald'
            ]
        );
    }
}
