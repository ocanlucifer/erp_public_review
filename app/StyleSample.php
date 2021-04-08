<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StyleSample extends Model
{
    protected $table = "style_sample";

    protected $nullable = ['id'];

    protected $fillable = [
        'name', 'tipe',
    ];
}
