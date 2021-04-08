<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Remark extends Model
{
    protected $table = "soremark";
    protected $nullable = ['id'];
    protected $fillable = ['id_remark_type', 'id_sales_order', 'description'];

    public function salessample()
    {
        return $this->belongsTo(Salessample::class, 'id_sales_order', 'id');
    }

    public function remarktype()
    {
        return $this->belongsTo(Remarktype::class, 'id_remark_type', 'id');
    }
}
