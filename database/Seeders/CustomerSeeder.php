<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            [
                'code' => 'BLK',
                'nama' => 'BELK',
                'alamat' => '-',
                'contact_name' => '-',
                'country_code' => 'USA',
                'phone' => '305051150',
                'top' => '0',
                'email' => 'simsons@mail.com',
                'npwp' => '-',
                'bank' => '-',
                'rekening' => '',
                'remarks' => '',
                'created_by' => '1',
                'updated_by' => ''
            ]
        ]);
    }
}
