<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table = "quotation_detail";

    protected $fillable = [
        'id_quot_header','jenis', 'position',
        'jenis_detail','description', 'supplier',
        'width','cons', 'allowance',
        'price','freight'
    ];

    public function quot_header(){
    	return $this->belongsTo('App\Quotation','code')->withDefault();
    }
}
