<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

    protected $fillable = [
        'code', 'nama', 'alamat', 'phone', 'top', 'email', 'contact_name', 'country_code',
        'npwp', 'bank', 'rekening', 'remarks', 'created_by', 'updated_by',
    ];

    public function user_create()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_code', 'kode')->withDefault();
    }
}
