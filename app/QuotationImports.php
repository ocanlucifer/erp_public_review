<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationImports extends Model
{
    protected $table = "quotation_imports";

    protected $fillable = [
        'filename','import_user', 'status_import',
    ];
}
