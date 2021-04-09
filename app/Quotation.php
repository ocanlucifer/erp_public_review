<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = "quotation";

    protected $fillable = [
        'code', 'cust', 'brand', 'season',
        'style', 'description', 'bu',
        'forecast_qty', 'delivery', 'size_range',
        'destination', 'tgl_quot', 'exchange_rate',
        'gambar', 'smv', 'rate', 'basis_order',
        'handling', 'margin', 'offer_price',
        'sales_fee', 'confirm_price', 'status', 'create_by', 'update_by', 'tgl_update'
    ];

    public function quot_detail()
    {
        return $this->hasMany('App\QuotationDetail', 'id_quot_header')->withDefault();
    }

    public function quot_gambar()
    {
        return $this->hasMany('App\QuotationImage', 'id_quot_header')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'create_by')->withDefault();
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'update_by')->withDefault();
    }
}
