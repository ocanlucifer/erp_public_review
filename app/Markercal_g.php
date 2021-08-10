<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markercal_g extends Model
{
    use HasFactory;
    protected $table = 'markercal_g';

    protected $nullable = [
        'id_markercal_g'
    ];

    protected $fillable = [
        'id_markercal_d', 'gramasi', 'kgdz', 'yddz', 'mddz'
    ];

    public function markercal_d()
    {
        return $this->belongsTo(Markercal_d::class, 'id_markercal_d', 'id_markercal')->withDefault();
    }
}
