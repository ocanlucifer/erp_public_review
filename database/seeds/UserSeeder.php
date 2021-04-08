<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name'                     => 'chandra',
                'kd_perusahaan'            => 'TPG',
                'kd_divisi'                => '1',
                'hak_akses'                => 'IT',
                'email'                    => 'chandra@teodore.com',
                'email_verified_at'        => '2020-01-07 11:06:48',
                'password'                 => '$2y$10$0qQaCkPHbJflqXQylJP2cegAv.U6ed83121uV8r6Phi.WDxMZY.ha'
            ],
            [
                'name'                     => 'fahmi',
                'kd_perusahaan'            => 'TPG',
                'kd_divisi'                => '1',
                'hak_akses'                => 'IT',
                'email'                    => 'fahmi_rk@teodore.com',
                'email_verified_at'        => '2020-10-12 11:00:40',
                'password'                 => '$2y$10$0qQaCkPHbJflqXQylJP2cegAv.U6ed83121uV8r6Phi.WDxMZY.ha'
            ]
        ]);
    }
}
