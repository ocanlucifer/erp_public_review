<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionMarker extends Model
{
     protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'number', 'style_name', 'order_name'
    ];
}
