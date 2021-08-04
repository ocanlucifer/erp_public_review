<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Markercal extends Model
{
    use HasFactory;
    protected $table = 'markercal';
    protected $nullable = 'id';
    protected $fillable = ['mc_number', 'order', 'style', 'combo', 'numbering', 'fabricconst', 'fabriccomp', 'revision', 'memo', 'created_by', 'updated_by'];
}
