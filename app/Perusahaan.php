<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = "perusahaan";

    protected $fillable = [
        'kd_perusahaan','nama_perusahaan','alamat','phone','logo',
    ];
}
