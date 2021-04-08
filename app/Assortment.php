<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assortment extends Model
{
    protected $table = "assortments";

    protected $nullable = ['id'];
    protected $fillable = ['id_sales_sample', 'id_size', 'id_color', 'quantity', 'tolerance'];

    public function salessample()
    {
        return $this->belongsTo(Salessample::class, 'id_sales_sample', 'id');
    }

    public function sizes()
    {
        return $this->belongsTo(Sizes::class, 'id_size', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id');
    }
}
