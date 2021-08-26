<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poacc_convertunit extends Model
{
    use HasFactory;

    protected $table = 'po_acc_convert_unit';
    protected $nullable = 'id';
    protected $fillable =  ['id_poacc', 'id_source_unit', 'id_target_unit', 'faktor'];

    public function source()
    {
        return $this->belongsTo(Unit::class, 'id_source_unit', 'code')->withDefault();
    }

    public function target()
    {
        return $this->belongsTo(Unit::class, 'id_target_unit', 'code')->withDefault();
    }
}
