<?php

use Illuminate\Database\Seeder;
use App\Fabricconst;

class FabricconstructSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fabricconst::insert([
            [
                'id'                => '1',
                'name'              => '100% Polyester',
                'material_type'     => 'Fabric',
                'state'             => 'confirmed'
            ],
            [
                'id'                => '2',
                'name'              => '100% Cotton',
                'material_type'     => 'Fabric',
                'state'             => 'confirmed'
            ]
        ]);
    }
}
