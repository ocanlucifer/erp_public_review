<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TipeBC;
use Requests;
use File;
use Session;
use Auth; 

class TipeBCController extends Controller
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
        $result = TipeBC::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = TipeBC::where('name','like','%'.strtoupper($request->name).'%')
          			->where('description','like','%'.strtoupper($request->description).'%')
          			->where('jenis','like','%'.strtoupper($request->jenis).'%')
                	->orderBy('name', 'asc')
                	->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('tipe_bc.list', array('result' => $result))->render());
      		} 
    	}

        return view('tipe_bc.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $tipe_bc = TipeBC::where('id','=',$request->id)->first();
          if($tipe_bc)
          {
            return \Response::json(\View::make('tipe_bc.editform', array('tipe_bc' => $tipe_bc))->render());
          } 
    }

    public function delete($id)
    {	
    	TipeBC::where('id',$id)->delete();
  		Session::flash('sukses','tipe_bc berhasil dihapus');
  		return redirect('/tipe_bc');
    }

    public function new()
    {
    	$name 				= Requests::input('name');
    	$description 		= Requests::input('description');
    	$jenis 				= Requests::input('jenis');

		TipeBC::create([
			'name'					=>	strtoupper($name),
			'description'			=>	strtoupper($description),
			'jenis'					=>	strtoupper($jenis),
		]);

		Session::flash('sukses','Data tipe_bc Berhasil Di simpan');
		return redirect('/tipe_bc');
    }

    public function update()
    {
        $id      			= Requests::input('id');
        $name    	  		= Requests::input('name');
    	$description 		= Requests::input('description');
    	$jenis 				= Requests::input('jenis');
        TipeBC::where('id',$id)->update([
            'name'       			=>  strtoupper($name),
			'description'			=>	strtoupper($description),
			'jenis'					=>	strtoupper($jenis),
        ]);
        Session::flash('sukses','Data tipe_bc Berhasil Di edit');
        return redirect('/tipe_bc');
    }
}
