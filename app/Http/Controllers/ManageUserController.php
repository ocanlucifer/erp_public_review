<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\User;
use Requests;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;

class ManageUserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth','verified']);

        $this->middleware(function ($request, $next) {
            if (Auth::user()->hak_akses <> 'IT') {
        		abort(403);
        	} else {
            	return $next($request);
        	}
        });
        
    }

    public function index(Request $request)
    {
        $result = User::orderBy('id', 'asc')
            ->paginate(10);
    	
    	if($request->ajax())
    	{
          	$result = User::where('name','like','%'.$request->name.'%')
          		->where('divisi','like','%'.$request->divisi.'%')
          		->where('hak_akses','like','%'.strtoupper($request->role).'%')
          		->where('email','like','%'.$request->email.'%')
                ->orderBy('id', 'asc')
                ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('manage_user.list', array('result' => $result))->render());
      		} 
    	}

        return view('manage_user.index', ['result'=>$result]);
    }

    public function delete($id)
    {
    	User::where('id',$id)->delete();
		Session::flash('sukses','User berhasil dihapus');
		return redirect('/manage_user');
    }

    public function resetPassword($id)
    {
    	$new_password 	= 'p@ssW0rd';
    	User::where('id',$id)->update([
			'password'		=>	Hash::make($new_password),
		]);
		Session::flash('sukses','Password Berhasil di reset, Default password adalah <b>p@ssW0rd</b>');
		return redirect('/manage_user');
    }

    public function updateRole()
    {
    	$id 	= Requests::input('id');
    	$newrole 	= Requests::input('newrole');
    	User::where('id',$id)->update([
			'hak_akses'		=>	$newrole,
		]);
		Session::flash('sukses','User Role Berhasil di update');
		return redirect('/manage_user');
    }
}
