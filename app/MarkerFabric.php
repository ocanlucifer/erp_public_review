<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkerFabric extends Model
{
    protected $table = "marker_fabric";

    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'id_marker', 'id_fabric_construct', 'id_fabric_compost', 'name', 'description', 'gramasi', 'unit', 'marker_type'
    ];

    public function fabricconst()
    {
        return $this->belongsTo(Fabricconst::class, 'id_fabric_construct', 'id');
    }

    public function fabriccomp()
    {
        return $this->belongsTo(Fabriccomp::class, 'id_fabric_compost', 'id');
    }

    public function marker()
    {
        return $this->belongsTo(Marker::class, 'id_marker', 'id');
    }
}
