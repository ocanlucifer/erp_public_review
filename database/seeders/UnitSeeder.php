<?php
namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Unit;

class UnitSeeder extends Seeder
{
    public function run()
    {
        Unit::insert([
            [
                'code' => '1',
                'name' => 'CM',
                'type' => 'size_spec'
            ], [
                'code' => '2',
                'name' => 'INC',
                'type' => 'size_spec'
            ]
        ]);
    }
}
