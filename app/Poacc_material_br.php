<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poacc_material_br extends Model
{
    use HasFactory;

    protected $table = 'po_acc_material_br';
    protected $nullable = 'id';
    protected $fillable =  ['id_material','id_color','id_size','id_unit','price','quantity'];

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id')->withDefault();
    }

    public function size()
    {
        return $this->belongsTo(Sizes::class, 'id_size', 'id')->withDefault();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'code')->withDefault();
    }

}
