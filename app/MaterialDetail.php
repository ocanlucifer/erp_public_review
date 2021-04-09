<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Size;

class MaterialDetail extends Model
{
    protected $table = 'material_details';
    protected $fillable = ['id_sales_sample', 'id_material_req', 'gmt_color', 'gmt_size', 'mat_color', 'mat_size', 'quantity', 'consumption', 'per_garment', 'unit', 'wastage', 'status', 'note'];
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
