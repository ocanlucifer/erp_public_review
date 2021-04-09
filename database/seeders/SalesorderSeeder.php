<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Salesorder;

class SalesorderSeeder extends Seeder
{
    public function run()
    {
        Salesorder::insert([
            [
                'id'                => '1',
                'number'            => 'SO14-00001',
                'code_quotation'    => 'Q2021-00001',
                'order_date'        => '2020-01-02',
                'delivery_date'     => '2020-02-02',
                'customer'           => 'BELK',
                'agent'             => 'CFL',
                'no_consumption'    => 'RKK/2020/00090',
                'state'             => 'PENDING',
                'style'             => 'BELK-SPRING',
                'art_number'        => 'ART NUMBER TEST',
                'brand'             => 'BELK',
                'season'            => 'SEASON TEST',
                'garment_type'      => '6998 POLO SHIRT',
                'style_group'       => 'BASIC',
                'cust_style_name'   => 'CUST STYLE TEST',
                'description'       => '-',
                'revision_note'     => '-'
            ]
        ]);
    }
}
