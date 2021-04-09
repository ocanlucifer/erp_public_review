<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perusahaan::create([
        	'kd_perusahaan'			=>	'TPG',
			'nama_perusahaan'		=>	'PT. Teodore Pan Garmindo',
            'alamat'                =>  'Jl. Industri IV No. 10 Leuwigajah - Cimahi',
			'phone'				    =>	'Telp. (022) 6007271 - 6007272 (Hunting) Fax. (022) 6007273',
			'logo'					=>	'logo-perusahaan/tpg.png',
        ]);
    }
}
