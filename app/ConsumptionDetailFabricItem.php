<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetailFabricItem extends Model
{
    use HasFactory;

    protected $table = "consumption_detail_fabric_item";
    protected $fillable = ['id','id_cons_sup','id_color','total_qty','komponen','width','w_unit','kons_budget',
    						'kons_marker','kons_efi','qty_unit','tole','qty_unit_tole','qty_sample','qty_purch',
    						'budget_price','supplier_price','amount','freight','amount_freight','unit'
    					];

    public function supplier_cons(){
    	return $this->belongsTo('App\ConsumptionDetailSupplier');
    }

    public function fab_color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id')->withDefault();
    }
}
