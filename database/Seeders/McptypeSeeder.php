<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Mcp_type;

class McptypeSeeder extends Seeder
{
    public function run()
    {
        Mcp_type::insert([
            [
                'id'            => '1',
                'mcp'           => 'MCP/21/00001',
                'id_wsheet'     => '1',
                'no_urut'       => '1',
                'type'          => 'MARKER',
                'fabricconst'  => '100% COTTON',
                'fabriccomp'   => 'BABY EYE PIQUE',
                'fabricdesc'   => 'DESC OF BABY',
                'component'     => 'BODY1',
                'warna'         => 'CORAL',
                'tujuan'        => 'BANDUNG, JAWA BARAT',
                'remark'        => '-',
                'created_by'    => 'FAHMI',
                'updated_by'    => '-'
            ],
            [
                'id'            => '2',
                'mcp'           => 'MCP/21/00001',
                'id_wsheet'     => '1',
                'no_urut'       => '2',
                'type'          => 'PIPING',
                'fabricconst'   => '100% COTTON',
                'fabriccomp'    => 'BABY EYE PIQUE',
                'fabricdesc'    => 'DESC OF BABY',
                'component'     => 'BODY1',
                'warna'         => 'CORAL',
                'tujuan'        => 'BANDUNG, JAWA BARAT',
                'remark'        => '-',
                'created_by'    => 'FAHMI',
                'updated_by'    => '-'
            ]
        ]);
    }
}
