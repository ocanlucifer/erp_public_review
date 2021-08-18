<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetailCollarCuffItem extends Model
{
    use HasFactory;

    protected $table = "consumption_detail_collar_cuff_item";
    protected $fillable = ['id', 'id_cons_sup', 'unit', 'id_color', 'total_qty', 'tole','qty_unit',
    						'total_qty_unit','total_qty_unit_pcs','freight','budget_price','supplier_price',
    						'amount','amount_freight'];

    public function fab_color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id')->withDefault();
    }

    public function collarcuffItemSize()
    {
        return $this->hasMany('App\ConsumptionDetailCollarCuffItemSize','id_collar_cuff','id');
    }
}
