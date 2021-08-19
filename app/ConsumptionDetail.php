<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetail extends Model
{
    use HasFactory;

    protected $table = "consumption_detail";
    protected $fillable = ['id', 'id_consumption', 'jenis', 'id_fab_cons', 'id_fab_comp', 'description'];

    public function ConsSupplier()
    {
        // return $this->belongsTo(ConsumptionDetailSupplier::class, 'id', 'id_detail')->withDefault();
        return $this->hasMany('App\ConsumptionDetailSupplier','id_detail','id');
    }

    public function fabricconst()
    {
        return $this->belongsTo(Fabricconst::class, 'id_fab_cons', 'id')->withDefault();
    }

    public function fabriccomp()
    {
        return $this->belongsTo(Fabriccomp::class, 'id_fab_comp', 'id')->withDefault();
    }
}
