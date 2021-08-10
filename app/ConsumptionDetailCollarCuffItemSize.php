<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetailCollarCuffItemSize extends Model
{
    use HasFactory;

    protected $table = "consumption_detail_collar_cuff_item_size";
    protected $fillable = ['id', 'id_collar_cuff', 'dimension', 'id_size', 'total', 'total_tole','total_rounded'];
}
