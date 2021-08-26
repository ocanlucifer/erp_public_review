<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poacc_material extends Model
{
    use HasFactory;
    protected $table = 'po_acc_material';
    protected $nullable = 'id';
    protected $fillable = ['id_poacc','id_sales_order', 'id_fabricconst', 'id_fabriccomp', 'id_style', 'fabric_desc', 'shipping_date', 'budget', 'material_type'];

    public function fabricconst()
    {
        return $this->belongsTo(Fabricconst::class, 'id_fabricconst', 'id')->withDefault();
    }

    public function fabriccomp()
    {
        return $this->belongsTo(Fabriccomp::class, 'id_fabriccomp', 'id')->withDefault();
    }

    public function salesorder()
    {
        return $this->belongsTo(Salesorder::class, 'id_sales_order', 'id')->withDefault();
    }

    public function style()
    {
        return $this->belongsTo(Style::class, 'id_style', 'id')->withDefault();
    }
}
