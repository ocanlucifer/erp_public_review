<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Mcp_detail;

class McpdetailSeeder extends Seeder
{
    public function run()
    {
        Mcp_detail::insert([
            [
                'id'            => '1',
                'mcp'           => 'MCP/21/00001',
                'id_type'       => '1',
                'urutan'        => '1',
                'code'          => 'CTEST001',
                'marker_date'   => '2021-04-14',
                'efisiensi'     => '90',
                'perimeter'     => '1',
                'designer'      => 'AGUSTINA',
                'tole_pjg_m'    => '0.1',
                'tole_lbr_m'    => '0.1',
                'kons_sz_tgh'   => '0.1',
                'tgl_sz_tgh'    => '2021-05-13',
                'panjang_m'     => '10',
                'panjang_m'     => '10',
                'lebar_m'       => '10',
                'gramasi'       => '20',
                'total_skala'   => '250',
                'jml_marker'    => '5',
                'jml_ampar'     => '10',
                'pdf_marker'    =>  '-',
                'komponen'      =>  '-',
                'revisi'        => '0',
                'revisi_remark' => '-'
            ]
        ]);
    }
}
