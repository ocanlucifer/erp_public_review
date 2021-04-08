<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SO_Materialreq extends Model
{
    protected $table = 'somaterialreqs';
    protected $nullable = 'id';
    protected $fillable = ['id_sales_order', 'number', 'id_fabric_construct', 'id_fabric_compost', 'fabric_description', 'budget', 'po_status', 'state', 'id_purchasing', 'note'];

    public function fabricconst()
    {
        return $this->belongsTo(Fabricconst::class, 'id_fabric_construct', 'id');
    }

    public function fabriccomp()
    {
        return $this->belongsTo(Fabriccomp::class, 'id_fabric_compost', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_purchasing', 'id');
    }
}
