<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mcp_assort extends Model
{
    protected $table = "mcp_assort";
    protected $nullable = "id";
    protected $fillable = ["mcp", "id_mcpwsm", "id_ws", "id_mcpt", "id_mcpd", "size", "qty_ws", "scale"];
}
