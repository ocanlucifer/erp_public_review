<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_detail extends Model
{
    protected $table = 'mp_detail';
    protected $fillable = ['id', 'mp', 'id_mpwsm', 'id_type', 'urutan', 'code', 'marker_date', 'efisiensi', 'perimeter', 'tole_pjg_m', 'tole_lbr_m', 'kons_sz_tgh', 'tgl_sz_tgh', 'panjang_m', 'lebar_m', 'gramasi', 'total_skala', 'jml_marker', 'jml_ampar', 'pdf_marker', 'komponen', 'revisi', 'revisi_remark'];
}
