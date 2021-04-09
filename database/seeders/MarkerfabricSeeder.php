<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\MarkerFabric;

class MarkerfabricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarkerFabric::insert([
            [
                'id'                       => '1',
                'id_marker'                => '1',
                'id_fabric_construct'      => '2',
                'id_fabric_compost'        => '3',
                'name'                     => 'Solid Jesrey',
                'description'              => '100% Cotton Jersey',
                'gramasi'                  => '0',
                'unit'                     => 'YD',
                'marker_type'              => 'Body 1'
            ],
            [
                'id'                       => '2',
                'id_marker'                => '1',
                'id_fabric_construct'      => '2',
                'id_fabric_compost'        => '4',
                'name'                     => 'Stripe Jersey',
                'description'              => '100% Cotton Jersey High',
                'gramasi'                  => '320',
                'unit'                     => 'KGS',
                'marker_type'              => 'Body 2'
            ]
        ]);
    }
}
