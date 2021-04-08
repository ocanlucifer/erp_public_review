<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcp_wsheet extends Model
{
    protected $table = 'mcp_wsheet';
    protected $nullable = 'id';

    protected $fillable = ['mcp', 'mcp_wsheet_m', 'no_urut', 'combo', 'size', 'ws_qty', 'tolerance', 'qty_tot'];
}
