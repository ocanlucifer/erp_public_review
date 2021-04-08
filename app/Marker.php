<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'nama_marker', 'style', 'no_document', 'date'
    ];
}
