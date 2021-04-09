<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\StyleSample;

class StyleSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StyleSample::insert([
            [
                'id' => '1',
                'name' => 'fit sample',
                'tipe' => '6997 polo shirt'
            ], [
                'id' => '2',
                'name' => 'extra sample',
                'tipe' => '6998 polo shirt'
            ]
        ]);
    }
}
