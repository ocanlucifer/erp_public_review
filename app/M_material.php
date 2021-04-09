<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_material extends Model
{
    protected $table = "m_material";

    protected $fillable = [
        'code','tipe','deskripsi',
        'remarks','created_by','updated_by',
    ];

    public function user_create(){
    	return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
    	return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}
