<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationImage extends Model
{
    protected $table = "quotation_image";

    protected $fillable = [
        'id_quot_header','file'
    ];

    public function gambar_header(){
    	return $this->belongsTo('App\Quotation','code');
    }
}
