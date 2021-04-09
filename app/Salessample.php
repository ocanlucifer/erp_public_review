<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salessample extends Model
{
    protected $table = "salessamples";
    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'number', 'order_date', 'delivery_date', 'customer', 'agent', 'state', 'style', 'art_number', 'brand', 'season', 'garment_type', 'style_group', 'sample_type', 'cust_style_name', 'description', 'revision_note'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer', 'code')->withDefault();
    }

    public function style()
    {
        return $this->belongsTo(Style::class, 'style', 'id')->withDefault();
    }

    public function stylesample()
    {
        return $this->belongsTo(StyleSample::class, 'sample_type', 'id')->withDefault();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand', 'id')->withDefault();
    }
}
