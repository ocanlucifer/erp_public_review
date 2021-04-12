<?php
namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Materialreq;

class MaterialreqSeeder extends Seeder
{
    public function run()
    {
        Materialreq::insert([
            [
                'id' => '1',
                'number' => 'MR9-001',
                'id_fabric_construct' => '1',
                'id_fabric_compost' => '1',
                'fabric_description' => 'good fabric',
                'budget' => 10000000,
                'po_status' => 'false',
                'state' => 'pending',
                'id_purchasing' => 3,
                'note' => 'nothing',
                'id_sales_sample' => '1',
            ], [
                'id' => '2',
                'number' => 'MR9-002',
                'id_fabric_construct' => '2',
                'id_fabric_compost' => '1',
                'fabric_description' => 'bad fabric',
                'budget' => 20000000,
                'po_status' => 'false',
                'state' => 'pending',
                'id_purchasing' => 3,
                'note' => 'nothing',
                'id_sales_sample' => '1',
            ]
        ]);
    }
}
