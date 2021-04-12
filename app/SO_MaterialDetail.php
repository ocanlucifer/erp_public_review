<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_MaterialDetail extends Model
{
    protected $table = 'somaterial_details';
    protected $fillable = ['id_sales_order', 'id_material_req', 'gmt_color', 'gmt_size', 'mat_color', 'mat_size', 'quantity', 'consumption', 'per_garment', 'unit', 'wastage', 'status', 'note'];
    protected $nullable = ['id'];

    public function materialRequest()
    {
        return $this->belongsTo(Materialreq::class, 'id_material_req', 'id')->withDefault();
    }

    public function gmtcolor()
    {
        return $this->belongsto(Color::class, 'gmt_color', 'name')->withDefault();
    }

    public function gmtsize()
    {
        return $this->belongsTo(Size::class, 'gmt_size', 'name')->withDefault();
    }
}
