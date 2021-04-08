<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipeBC extends Model
{
    protected $table = "tipe_bc";

    protected $fillable = [
        'name','description','jenis',
    ];
}
