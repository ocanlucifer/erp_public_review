<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    protected $table = "remark";
    protected $nullable = ['id'];
    protected $fillable = ['id_remark_type', 'id_sales_sample', 'description'];

    public function salessample()
    {
        return $this->belongsTo(Salessample::class, 'id_sales_sample', 'id')->withDefault();
    }

    public function remarktype()
    {
        return $this->belongsTo(Remarktype::class, 'id_remark_type', 'id')->withDefault();
    }
}
