<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Image extends Model
{
    protected $table = 'soimages';

    protected $nullable = 'id';
    protected $fillable = ['id_sales_order', 'image_type', 'source'];
}
