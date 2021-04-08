<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
    protected $fillable = [
        'name','weight','status',
    ];
}
