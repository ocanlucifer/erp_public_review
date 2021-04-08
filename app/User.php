<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'hak_akses', 'kd_perusahaan', 'kd_divisi', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_divisi(){
        // return $this->belongsTo(Divisi::class, 'kd_divisi');
        return $this->hasOne('App\Divisi', 'id', 'kd_divisi');
    }
    public function user_perusahaan(){
        // return $this->belongsTo(Perusahaan::class, 'kd_perusahaan');
        return $this->hasOne('App\Perusahaan', 'kd_perusahaan', 'kd_perusahaan');
    }

}
