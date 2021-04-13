<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Mcp;

class McpSeeder extends Seeder
{
    public function run()
    {
        Mcp::insert([
            [
                'id'            => '1',
                'number'        => 'MCP/21/00001',
                'order_name'    => 'SCREAMOUS',
                'fabric_const'  => '100% COTTON',
                'fabric_comp'   => 'BABY EYE PIQUE',
                'fabric_desc'   => 'DESC OF BABY',
                'style'         => 'BELK-SUMMER',
                'style_desc'    => 'DESC OF BELK',
                'delivery_date' => '2021-05-12',
                'revision_count' => '0',
                'revisi_remark' => 'TOLERANCE P=1INC/L=1NC',
                'state'         => 'PENDING',
                'created_by'    => 'FAHMI',
                'updated_by'    => '-',
                'confirmed_by'  => '-'
            ]
        ]);
    }
}
