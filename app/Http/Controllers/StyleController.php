<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Style;
use Requests;
use File;
use Session;
use Auth; 


class StyleController extends Controller
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
        $result = Style::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Style::where('name','like','%'.strtoupper($request->name).'%')
                    ->where('tipe','like','%'.strtoupper($request->tipe).'%')
                	->orderBy('name', 'asc')
                	->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('style.list', array('result' => $result))->render());
      		} 
    	}

        return view('style.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $style = Style::where('id','=',$request->id)->first();
          if($style)
          {
            return \Response::json(\View::make('style.editform', array('style' => $style))->render());
          } 
    }

    public function delete($id)
    {	
    	Style::where('id',$id)->delete();
  		Session::flash('sukses','style berhasil dihapus');
  		return redirect('/style');
    }

    public function new()
    {
        $name       = Requests::input('name');
    	$tipe 		= Requests::input('tipe');

		Style::create([
            'name'          =>  strtoupper($name),
			'tipe'			=>	strtoupper($tipe),
		]);

		Session::flash('sukses','Data style Berhasil Di simpan');
		return redirect('/style');
    }

    public function update()
    {
        $id      		= Requests::input('id');
        $name           = Requests::input('name');
        $tipe    	  	= Requests::input('tipe');
        Style::where('id',$id)->update([
            'name'       =>  strtoupper($name),
            'tipe'       =>  strtoupper($tipe),
        ]);
        Session::flash('sukses','Data style Berhasil Di edit');
        return redirect('/style');
    }
}
