<?php

use App\Remarktype;
use Illuminate\Database\Seeder;

class RemarktypeSeeder extends Seeder
{
    public function run()
    {
        Remarktype::insert([
            [
                'id' => '1',
                'name' => 'fabric'
            ], [
                'id' => '2',
                'name' => 'accessories'
            ]
        ]);
    }
}
