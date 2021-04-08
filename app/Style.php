<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = "style";

    protected $fillable = [
        'name','tipe',
    ];
}
