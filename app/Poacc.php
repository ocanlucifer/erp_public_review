<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poacc extends Model
{
    use HasFactory;

    protected $table = 'po_acc';
    protected $nullable = 'id';
    protected $fillable = ['number', 'supplier', 'currency', 'exchange_rate', 'order_date', 'start_date', 'end_date', 'price_term', 'payment_term', 'bank_charges', 'note', 'rounding_value', 'allowance_qty', 'state', 'printed_count', 'created_by', 'updated_by', 'reviewed_by', 'confirmed_by'];
}
