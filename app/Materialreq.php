<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materialreq extends Model
{
    protected $table = 'materialreqs';
    protected $nullable = 'id';
    protected $fillable = ['number', 'id_fabric_construct', 'id_fabric_compost', 'fabric_description', 'budget', 'po_status', 'state', 'id_purchasing', 'note', 'id_sales_sample'];

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
