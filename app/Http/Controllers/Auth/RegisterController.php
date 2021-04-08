<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // $messages = [
        //     'email_domain' => 'gunakan email teodore anda, contoh (example@teodore.com)',
        // ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'unique:user'],
            'kd_perusahaan' => ['required', 'string', 'max:255'],
            'kd_divisi' => ['required', 'string', 'max:255'],
            // 'email' => ['required','email_domain:' . $data["email"] , 'string', 'email', 'max:255', 'unique:user'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ],$messages);
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => strtolower($data['name']),
            'kd_perusahaan' => strtoupper($data['kd_perusahaan']),
            'kd_divisi' => strtoupper($data['kd_divisi']),
            'hak_akses' => strtoupper('USER'),
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
        ]);
    }
}
