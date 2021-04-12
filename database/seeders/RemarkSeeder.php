<?php
namespace Database\Seeders;

namespace Database\Seeders;

use App\Remark;
use Illuminate\Database\Seeder;

class RemarkSeeder extends Seeder
{

    public function run()
    {
        Remark::insert([
            [
                'id' => '1',
                'id_remark_type' => '1',
                'id_sales_sample' => '9',
                'description' => 'very very good'
            ], [
                'id' => '2',
                'id_remark_type' => '2',
                'id_sales_sample' => '9',
                'description' => 'nice nice so nice'
            ]
        ]);
    }
}
