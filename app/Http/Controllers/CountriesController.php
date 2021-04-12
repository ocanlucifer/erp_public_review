<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Countries;
use Requests;
use File;
use Session;
use Auth; 

class CountriesController extends Controller
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
        $result = Countries::orderBy('kode', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Countries::where('kode','like','%'.strtoupper($request->kode).'%')
          		  ->where('name','like','%'.strtoupper($request->name).'%')
                  ->orderBy('kode', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('countries.list', array('result' => $result))->render());
      		} 
    	}

        return view('countries.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $countries = Countries::where('id','=',$request->id)->first();
          if($countries)
          {
            return \Response::json(\View::make('countries.editform', array('countries' => $countries))->render());
          } 
    }

    public function delete($id)
    {	
    	Countries::where('id',$id)->delete();
		Session::flash('sukses','countries berhasil dihapus');
		return redirect('/countries');
    }

    public function new()
    {
    	$kode 		= Requests::input('kode');
    	$name 		= Requests::input('name');

		Countries::create([
			'kode'			=>	strtoupper($kode),
			'name'			=>	strtoupper($name),
		]);

		Session::flash('sukses','Data countries Berhasil Di simpan');
		return redirect('/countries');
    }

    public function update()
    {
        $id      	= Requests::input('id');
        $kode    	= Requests::input('kode');
        $name    	= Requests::input('name');
        Countries::where('id',$id)->update([
            'kode'       =>  strtoupper($kode),
            'name'       =>  strtoupper($name),
        ]);
        Session::flash('sukses','Data countries Berhasil Di edit');
        return redirect('/countries');
    }
}
