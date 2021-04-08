<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcp_wsheet_main extends Model
{
    protected $table = 'mcp_wsheet_main';
    protected $nullable = 'id';

    protected $fillable = ['mcp', 'no_urut', 'combo', 'total_qty'];
}
