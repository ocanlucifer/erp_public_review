<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Style;

class StyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Style::insert([
            [
                'id' => '1',
                'name' => 'belk-spring',
                'tipe' => 'sweat jacket'
            ], [
                'id' => '2',
                'name' => 'belk-summer',
                'tipe' => 'ladies dress'
            ]
        ]);
    }
}
