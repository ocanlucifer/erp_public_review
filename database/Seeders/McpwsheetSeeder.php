<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Mcp_wsheet;

class McpwsheetSeeder extends Seeder
{
    public function run()
    {
        Mcp_wsheet::insert([
            [
                'id'            => '1',
                'mcp'           => 'MCP/21/00001',
                'mcp_wsheet_m'  => '1',
                'no_urut'       => '1',
                'combo'         => 'CORAL',
                'size'          => 'M',
                'ws_qty'        => '100',
                'tolerance'     => '3',
                'qty_tot'       => '103'
            ],
            [
                'id'            => '2',
                'mcp'           => 'MCP/21/00001',
                'mcp_wsheet_m'  => '1',
                'no_urut'       => '2',
                'combo'         => 'CORAL',
                'size'          => 'L',
                'ws_qty'        => '50',
                'tolerance'     => '2',
                'qty_tot'       => '52'
            ],
            [
                'id'            => '3',
                'mcp'           => 'MCP/21/00001',
                'mcp_wsheet_m'  => '1',
                'no_urut'       => '3',
                'combo'         => 'CORAL',
                'size'          => 'XL',
                'ws_qty'        => '30',
                'tolerance'     => '1',
                'qty_tot'       => '31'
            ]
        ]);
    }
}
