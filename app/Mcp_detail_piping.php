<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcp_detail_piping extends Model
{
    protected $table = 'mcp_detail_piping';
    protected $nullable = 'id';
    protected $fillable = ['mcp', 'id_mcpwsm', 'id_type', 'untuk', 'ukuran', 'arah', 'urutan', 'kode_marker', 'marker_date', 'efisiensi', 'perimeter', 'tole_pjg_m', 'tole_lbr_m', 'pdf_marker', 'panjang_m', 'lebar_m', 'mp_pcs', 'pola_asli', 'gramasi', 'skala', 'jml_ampar', 'kons_sz_tgh', 'tgl_sz_tgh', 'tot_ws_qty', 'tolerance', 'revision', 'revision_remark'];
}
