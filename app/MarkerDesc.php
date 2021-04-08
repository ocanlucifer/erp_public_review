<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarkerDesc extends Model
{
    protected $table = "marker_desc";
    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'markerfab_id', 'width', 'quantity', 'consumption', 'efficiency', 'qty_unit', 'act_unit'
    ];

    public function markerFabric()
    {
        return $this->belongsTo(MarkerFabric::class, 'markerfab_id', 'id');
    }
}
