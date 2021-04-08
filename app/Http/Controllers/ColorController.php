<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Color;
use Input;
use File;
use Session;
use Auth; 

class ColorController extends Controller
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
        $result = Color::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Color::where('name','like','%'.strtoupper($request->name).'%')
                	->orderBy('name', 'asc')
                	->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('color.list', array('result' => $result))->render());
      		} 
    	}

        return view('color.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $color = Color::where('id','=',$request->id)->first();
          if($color)
          {
            return \Response::json(\View::make('color.editform', array('color' => $color))->render());
          } 
    }

    public function delete($id)
    {	
    	Color::where('id',$id)->delete();
  		Session::flash('sukses','color berhasil dihapus');
  		return redirect('/color');
    }

    public function new()
    {
    	$name 		= Input::get('name');

		Color::create([
			'name'			=>	strtoupper($name),
		]);

		Session::flash('sukses','Data color Berhasil Di simpan');
		return redirect('/color');
    }

    public function update()
    {
        $id      		= Input::get('id');
        $name    	  	= Input::get('name');
        Color::where('id',$id)->update([
            'name'       =>  strtoupper($name),
        ]);
        Session::flash('sukses','Data color Berhasil Di edit');
        return redirect('/color');
    }
}
