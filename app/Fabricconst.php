<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricconst extends Model
{

    protected $table = "fabricconstruct";

    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'name', 'material_type', 'state',
    ];
}
