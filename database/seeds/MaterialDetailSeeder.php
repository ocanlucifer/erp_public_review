<?php

use Illuminate\Database\Seeder;
use App\MaterialDetail;

class MaterialDetailSeeder extends Seeder
{
    public function run()
    {
        MaterialDetail::insert([
            [
                'id' => '1',
                'id_sales_sample' => '1',
                'id_material_req' => '1',
                'gmt_color' => 'coral',
                'gmt_size' => '12',
                'mat_color' => 'coral',
                'mat_size' => '50MMx23MM',
                'quantity' => '185',
                'consumption' => '2',
                'per_garment' => '1',
                'unit' => 'pcs',
                'wastage' => '3',
                'status' => 'false',
                'note' => '-',
            ], [
                'id' => '2',
                'id_sales_sample' => '1',
                'id_material_req' => '2',
                'gmt_color' => 'emerald',
                'gmt_size' => '12',
                'mat_color' => 'emerald',
                'mat_size' => '50MMx23MM',
                'quantity' => '110',
                'consumption' => '2',
                'per_garment' => '1',
                'unit' => 'pcs',
                'wastage' => '3',
                'status' => 'false',
                'note' => '-',
            ]
        ]);
    }
}
