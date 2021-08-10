<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetailSupplier extends Model
{
    use HasFactory;

    protected $table = "consumption_detail_supplier";
    protected $fillable = ['id','id_detail','supplier_code'];

    public function detail_cons(){
    	return $this->belongsTo('App\ConsumptionDetail');
    }

    public function FabItem()
    {
        return $this->hasMany('App\ConsumptionDetailFabricItem','id_cons_sup','id');
    }

    public function collarcuffItem()
    {
        return $this->hasMany('App\ConsumptionDetailCollarCuffItem','id_cons_sup','id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_code', 'code')->withDefault();
    }
}
