<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Salessample;

class SalessampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salessample::insert([
            [
                'id'                => '1',
                'number'            => 'SPL14-00001',
                'order_date'        => '2020-01-02',
                'delivery_date'     => '2020-02-02',
                'customer'          => 'BELK',
                'agent'             => 'CFL',
                'state'             => 'PENDING',
                'style'             => 'BELK-SPRING',
                'art_number'        => 'ART NUMBER TEST',
                'brand'             => 'BELK',
                'season'            => 'SEASON TEST',
                'garment_type'      => '6997 POLO SHIRT',
                'style_group'       => 'BASIC',
                'sample_type'       => 'FIT SAMPLE',
                'cust_style_name'   => 'CUST STYLE TEST',
                'description'       => 'GOOD',
                'revision_note'     => '-'
            ]
        ]);
    }
}
