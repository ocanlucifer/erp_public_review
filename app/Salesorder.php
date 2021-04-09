<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesorder extends Model
{
    protected $table = "salesorders";
    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'number', 'code_quotation', 'order_date', 'delivery_date', 'customer', 'agent', 'no_consumption', 'state', 'style', 'art_number', 'brand', 'season', 'garment_type', 'style_group', 'cust_style_name', 'description', 'revision_note'
    ];

    public function customer_list()
    {
        return $this->belongsTo(Customer::class, 'customer', 'code')->withDefault();
    }

    public function style_list()
    {
        return $this->belongsTo(Style::class, 'style', 'id')->withDefault();
    }

    public function brand_list()
    {
        return $this->belongsTo(Brand::class, 'brand', 'id')->withDefault();
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'code_quotation', 'code')->withDefault();
    }
}
