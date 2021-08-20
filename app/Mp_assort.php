<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mp_assort extends Model
{
    protected $table = 'mp_assort';
    protected $fillable = ['id', 'mp', 'id_mpwsm', 'id_ws', 'id_mpt', 'id_mpd', 'size', 'qty_ws', 'scale'];
}
