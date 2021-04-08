<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sizespec extends Model
{
    protected $table = "sizespecs";
    protected $nullable = ['id'];
    protected $fillable = ['id_sales_sample', 'id_size', 'value', 'specification', 'allowance', 'position', 'unit'];

    public function salessample()
    {
        return $this->belongsTo(Salessample::class, 'id_sales_sample', 'id');
    }

    public function sizes()
    {
        return $this->belongsTo(Sizes::class, 'id_size', 'id');
    }
}
