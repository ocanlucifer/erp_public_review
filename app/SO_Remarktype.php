<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Remarktype extends Model
{
    protected $table = "soremark_type";
    protected $nullable = ['id'];
    protected $fillable = ['name'];
}
