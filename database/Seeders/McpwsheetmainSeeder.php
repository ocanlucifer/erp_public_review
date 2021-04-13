<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Mcp_wsheet_main;

class McpwsheetmainSeeder extends Seeder
{
    public function run()
    {
        Mcp_wsheet_main::insert([
            [
                'id'            => '1',
                'mcp'           => 'MCP/21/00001',
                'no_urut'       => '1',
                'combo'         => 'CORAL',
                'total_qty'     => '186'
            ]
        ]);
    }
}
