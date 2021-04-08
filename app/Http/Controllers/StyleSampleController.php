<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StyleSample;
use Input;
use File;
use Session;
use Auth; 

class StyleSampleController extends Controller
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
        $result = StyleSample::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = StyleSample::where('name','like','%'.strtoupper($request->name).'%')
                    ->where('tipe','like','%'.strtoupper($request->tipe).'%')
                	->orderBy('name', 'asc')
                	->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('style_sample.list', array('result' => $result))->render());
      		} 
    	}

        return view('style_sample.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $style_sample = StyleSample::where('id','=',$request->id)->first();
          if($style_sample)
          {
            return \Response::json(\View::make('style_sample.editform', array('style_sample' => $style_sample))->render());
          } 
    }

    public function delete($id)
    {	
    	StyleSample::where('id',$id)->delete();
  		Session::flash('sukses','style_sample berhasil dihapus');
  		return redirect('/style_sample');
    }

    public function new()
    {
        $name       = Input::get('name');
    	$tipe 		= Input::get('tipe');

		StyleSample::create([
            'name'          =>  strtoupper($name),
			'tipe'			=>	strtoupper($tipe),
		]);

		Session::flash('sukses','Data style_sample Berhasil Di simpan');
		return redirect('/style_sample');
    }

    public function update()
    {
        $id      		= Input::get('id');
        $name           = Input::get('name');
        $tipe    	  	= Input::get('tipe');
        StyleSample::where('id',$id)->update([
            'name'       =>  strtoupper($name),
            'tipe'       =>  strtoupper($tipe),
        ]);
        Session::flash('sukses','Data style_sample Berhasil Di edit');
        return redirect('/style_sample');
    }
}
