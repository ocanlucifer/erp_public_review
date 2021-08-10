<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markercal_d extends Model
{
    use HasFactory;
    protected $table = 'markercal_d';
    protected $nullable = 'id';
    protected $fillable = ['id_markercal', 'fabricconst', 'fabriccomp', 'kode', 'calculation_date', 'size_name', 'pdf_marker', 'pjg_m', 'lbr_m', 'tole_pjg_m', 'tole_lbr_m', 'efficiency', 'perimeter', 'total_scale', 'color_name', 'revision', 'fabric_type', 'remark', 'revisionRemark', 'ordering'];

    function markercal()
    {
        return $this->belongsTo(Markercal::class, 'id_markercal', 'id')->withDefault();
    }

    function markercal_g()
    {
        return $this->hasMany(Markercal_g::class, 'id_markercal_d', 'id');
    }
}
