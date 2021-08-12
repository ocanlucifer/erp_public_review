<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_wsheet_main extends Model
{
    protected $table = 'mp_wsheet_main';
    protected $fillable = ['id', 'mp', 'no_urut', 'combo', 'total_qty'];
}
