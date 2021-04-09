<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Divisi::create([
        	'id'				=>	1,
        	'nama_divisi'		=>	'INFORMATION TECHNOLOGI',
        ]);
    }
}
