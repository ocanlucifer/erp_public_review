<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleImage extends Model
{
    protected $table = 'sampleimages';

    protected $nullable = 'id';
    protected $fillable = ['id_sales_sample', 'image_type', 'source'];
}
