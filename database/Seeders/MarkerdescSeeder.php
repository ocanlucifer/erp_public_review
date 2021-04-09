<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\MarkerDesc;

class MarkerdescSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MarkerDesc::insert([
            [
                'id'                        => '1',
                'markerfab_id'              => '1',
                'width'                      => '57',
                'quantity'                  => '504',
                'consumption'               => '6.22',
                'efficiency'                => '90.96',
                'qty_unit'                  => '261.2',
                'act_unit'                  => '237.6'
            ],
            [
                'id'                        => '2',
                'markerfab_id'              => '1',
                'width'                      => '25',
                'quantity'                  => '504',
                'consumption'               => '0.28',
                'efficiency'                => '91.61',
                'qty_unit'                  => '11.6',
                'act_unit'                  => '10.6'
            ],
            [
                'id'                        => '3',
                'markerfab_id'              => '2',
                'width'                      => '30',
                'quantity'                  => '520',
                'consumption'               => '0.35',
                'efficiency'                => '90.2',
                'qty_unit'                  => '15',
                'act_unit'                  => '13'
            ]
        ]);
    }
}
