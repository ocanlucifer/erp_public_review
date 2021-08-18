<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_wsheet extends Model
{
    protected $table = 'mp_wsheet';
    protected $fillable = ['id', 'mp', 'mp_wsheet_m', 'no_urut', 'combo', 'size', 'ws_qty', 'tolerance', 'qty_tot'];
}
