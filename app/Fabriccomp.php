<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabriccomp extends Model
{
    protected $table = "fabriccomposts";

    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'name', 'fabricconstruct_id', 'type_name', 'state'
    ];

    public function fabricconst()
    {
        return $this->belongsTo(Fabricconst::class, 'fabricconstruct_id', 'id')->withDefault();
    }
}
