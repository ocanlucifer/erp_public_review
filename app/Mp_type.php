<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_type extends Model
{
    protected $table = 'mp_type';
    protected $fillable = ['id', 'mp', 'id_wsheet', 'no_urut', 'type', 'fabricconst', 'fabriccomp', 'fabricdesc', 'component', 'warna', 'tujuan', 'remark', 'created_by', 'updated_by'];
}
