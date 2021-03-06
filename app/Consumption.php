<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    protected $table = "consumptions";
    protected $fillable = ['id', 'code', 'code_quotation', 'customer', 'customer_style', 'number_mp', 'size_tengah', 'delivery_date', 'references_date', 'net_price', 'status'];
    // protected $nullable = ['size_tengah', 'references_date'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'code_quotation', 'code')->withDefault();
    }

    public function cust()
    {
        return $this->belongsTo(Customer::class, 'customer', 'nama')->withDefault();
    }

    public function styles()
    {
        return $this->belongsTo(Style::class, 'customer_style', 'name')->withDefault();
    }

    // public function mp()
    // {
    //     return $this->belongsTo(MarkerProduction::class, 'number_mp', 'number');
    // }

    public function salesorder()
    {
        return $this->belongsTo(Salesorder::class, 'code_quotation', 'code_quotation')->withDefault();
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function reviewedBy(){
        return $this->belongsTo(User::class, 'reviewed_by')->withDefault();
    }

    public function confirmedBy(){
        return $this->belongsTo(User::class, 'confirmed_by')->withDefault();
    }

    public function unconfirmedBy(){
        return $this->belongsTo(User::class, 'unconfirmed_by')->withDefault();
    }
}
