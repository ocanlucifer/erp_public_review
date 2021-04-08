<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sizes;
use Input;
use File;
use Session;
use Auth; 

class SizeController extends Controller
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
        $result = Sizes::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Sizes::where('name','like','%'.strtoupper($request->name).'%')
          		    ->where('weight','like','%'.strtoupper($request->weight).'%')
          		    ->where('status','like','%'.$request->status.'%')
                  ->orderBy('name', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('size.list', array('result' => $result))->render());
      		} 
    	}

        return view('size.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $size = Sizes::where('name','=',$request->id)->first();
          if($size)
          {
            return \Response::json(\View::make('size.editform', array('size' => $size))->render());
          } 
    }

    public function delete($name)
    {	
    	Sizes::where('name',$name)->delete();
  		Session::flash('sukses','size berhasil dihapus');
  		return redirect('/size');
    }

    public function new()
    {
    	$name 			= Input::get('name');
    	$weight 		= Input::get('weight');
    	$status 		= Input::get('status');

		Sizes::create([
			'name'				=>	strtoupper($name),
			'weight'			=>	strtoupper($weight),
			'status'			=>	$status,
		]);

		Session::flash('sukses','Data size Berhasil Di simpan');
		return redirect('/size');
    }

    public function update()
    {
        $name      		= Input::get('name');
        $weight    	  	= Input::get('weight');
        $status    	  	= Input::get('status');
        Sizes::where('name',$name)->update([
            'weight'       =>  strtoupper($weight),
            'status'       =>  $status,
        ]);
        Session::flash('sukses','Data size Berhasil Di edit');
        return redirect('/size');
    }
}
