<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp extends Model
{
    protected $table = 'mp';
    protected $fillable = ['id', 'id_sales_order', 'number', 'order_name', 'fabric_const', 'fabric_comp', 'fabric_desc', 'style', 'style_desc', 'delivery_date', 'revision_count', 'revisi_remark', 'state', 'created_by', 'updated_by', 'confirmed_by'];

    public function sales_order()
    {
        return $this->belongsTo(Salesorder::class, 'id_sales_order', 'id')->withDefault();
    }
}
