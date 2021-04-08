<?php

use Illuminate\Database\Seeder;
use App\Marker;

class MarkerSeeder extends Seeder
{
    public function run()
    {
        Marker::insert([
            [
                'id'               => '1',
                'nama_marker'      => 'Bonton',
                'style'            => 'mm6sx4204',
                'no_document'      => 'CM-MARK-111',
                'date'             => ''
            ],
            [
                'id'               => '2',
                'nama_marker'      => 'Belk Boys SP15',
                'style'            => '6BD4686531',
                'no_document'      => 'CM-MARK-112',
                'date'             => ''
            ]
        ]);
    }
}
