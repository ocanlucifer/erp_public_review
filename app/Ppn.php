<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ppn extends Model
{
    //
    protected $table = "ppn";

    protected $fillable = [
        'ppn','rate',
    ];
}

