<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Assortment extends Model
{
    protected $table = "so_assortments";

    protected $nullable = ['id'];
    protected $fillable = ['id_sales_order', 'id_size', 'id_color', 'quantity', 'tolerance'];

    public function salesorder()
    {
        return $this->belongsTo(Salesorder::class, 'id_sales_order', 'id');
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
