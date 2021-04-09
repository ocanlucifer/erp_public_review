<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "supplier";

    protected $fillable = [
        'code','nama','alamat','phone','top','email','contact_name','country_code',
        'npwp','bank','rekening','remarks','created_by','updated_by',
        'payment_term','price_term','currency','exchange_rate','ppn'
    ];

    public function user_create(){
    	return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
    	return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_code','kode')->withDefault();
    }
    public function currencies(){
        return $this->belongsTo(Currencies::class, 'currency','code')->withDefault();
    }
}
