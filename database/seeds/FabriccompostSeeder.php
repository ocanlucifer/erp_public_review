<?php

use Illuminate\Database\Seeder;
use App\Fabriccomp;

class FabriccompostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fabriccomp::insert([
            [
                'id'                    => '1',
                'name'                  => 'Zet Fleece',
                'fabricconstruct_id'    => '1',
                'type_name'             => 'goods',
                'state'                 => 'confirmed'
            ],
            [
                'id'                    => '2',
                'name'                  => 'RIB 1x1',
                'fabricconstruct_id'    => '1',
                'type_name'             => 'goods',
                'state'                 => 'confirmed'
            ],
            [
                'id'                    => '3',
                'name'                  => 'Jersey Printed',
                'fabricconstruct_id'    => '2',
                'type_name'             => 'goods',
                'state'                 => 'confirmed'
            ],
            [
                'id'                    => '4',
                'name'                  => 'Baby Eye Pique',
                'fabricconstruct_id'    => '2',
                'type_name'             => 'goods',
                'state'                 => 'confirmed'
            ]
        ]);
    }
}
