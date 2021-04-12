<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Sizespec extends Model
{
    protected $table = "sosizespecs";
    protected $nullable = ['id'];
    protected $fillable = ['id_sales_order', 'id_size', 'value', 'specification', 'allowance', 'position', 'unit'];

    public function salessample()
    {
        return $this->belongsTo(Salessample::class, 'id_sales_order', 'id')->withDefault();
    }

    public function sizes()
    {
        return $this->belongsTo(Sizes::class, 'id_size', 'id')->withDefault();
    }
}
