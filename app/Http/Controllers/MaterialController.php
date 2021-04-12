<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\M_material;
use File;
use Session;
use Auth;

class MaterialController extends Controller
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
        $result = M_material::orderBy('code', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = M_material::where('code','like','%'.strtoupper($request->code).'%')
                  ->where('tipe','like','%'.$request->tipe.'%')
                  ->where('deskripsi','like','%'.$request->deskripsi.'%')
                  ->orderBy('code', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('material.list', array('result' => $result))->render());
      		} 
    	}

        return view('material.index', ['result'=>$result]);
    }

    public function new()
  	{
  		return view('material.new_form');
  	}

  	public function edit($code)
  	{
  		$material = M_material::where('code',$code)->first();
  		return view('material.edit_form',['material'=>$material]);
  	}

  	public function save(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:100', 'unique:m_material'],
	    	'tipe' 				=> ['required', 'string', 'max:60'],
        'deskripsi'   => ['required', 'string', 'max:255', 'unique:m_material'],
	    	'remarks' 		=> ['max:255'],
	    	'created_by' 	=> ['required'],
    	]);

		M_material::create([
			'code'					=>	strtoupper($request->code),
			'tipe'					=>	$request->tipe,
      'deskripsi'     =>  strtoupper($request->deskripsi),
			'remarks'				=>	$request->remarks,
			'created_by'		=>	$request->created_by,
		]);

		Session::flash('sukses','Data Material '.strtoupper($request->code).' ('.$request->tipe.') Berhasil Di simpan');
		return redirect('/material');
    }

    public function update(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:100'],
	    	'tipe' 				=> ['required', 'string', 'max:60'],
        'deskripsi'   => ['required', 'string', 'max:255'],
	    	'remarks' 		=> ['max:255'],
	    	'updated_by' 	=> ['required'],
    	]);

		M_material::where('code',$request->code)->update([
			'tipe'					=>	$request->tipe,
      'deskripsi'     =>  strtoupper($request->deskripsi),
			'remarks'				=>	$request->remarks,
			'updated_by'		=>	$request->updated_by,
		]);

		Session::flash('sukses','Data Material '.strtoupper($request->code).' - '.$request->tipe.' Berhasil Di Update');
		return redirect('/material');
    }

    public function delete($code)
    {	
    	M_material::where('code',$code)->delete();
		Session::flash('sukses','Data Material '.$code.' berhasil dihapus');
		return redirect('/material');
    }
}
