<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";

    protected $nullable = [
        'id'
    ];
    protected $fillable = [
        'no_document', 'date', 'halaman', 'revisi'
    ];
}
