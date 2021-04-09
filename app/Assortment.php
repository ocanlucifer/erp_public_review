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
        return $this->belongsTo(Salessample::class, 'id_sales_sample', 'id')->withDefault();
    }

    public function sizes()
    {
        return $this->belongsTo(Sizes::class, 'id_size', 'id')->withDefault();
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id')->withDefault();
    }
}
