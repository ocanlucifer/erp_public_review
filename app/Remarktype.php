<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remarktype extends Model
{
    protected $table = "remark_type";
    protected $nullable = ['id'];
    protected $fillable = ['name'];
}
