<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{

    protected $fillable = [
        'kode','name',
    ];
}
