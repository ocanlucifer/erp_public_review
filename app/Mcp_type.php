<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcp_type extends Model
{
    protected $table = 'mcp_type';
    protected $nullable = 'id';

    protected $fillable = ['mcp', 'id_wsheet', 'no_urut', 'type', 'fabricconst', 'fabriccomp', 'fabricdesc', 'component', 'warna', 'tujuan', 'remark', 'created_by', 'updated_by'];
}
