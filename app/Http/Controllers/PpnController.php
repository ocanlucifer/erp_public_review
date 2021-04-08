<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ppn;
use Input;
use File;
use Session;
use Auth; 

class PpnController extends Controller
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
        $result = Ppn::orderBy('id', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Ppn::where('ppn','like','%'.$request->ppn.'%')
                  ->orderBy('id', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('ppn.list', array('result' => $result))->render());
      		} 
    	}

        return view('ppn.index', ['result'=>$result]);
    }

    public function delete($id)
    {	
    	Ppn::where('id',$id)->delete();
		Session::flash('sukses','Ppn berhasil dihapus');
		return redirect('/ppn');
    }

    public function new()
    {
    	$id 		= Input::get('id');
    	$ppn 		= Input::get('ppn');
    	$rate 		= Input::get('rate');
    	
		Ppn::create([
			'ppn'			=>	$ppn,
			'rate'			=>	$rate,
		]);

		Session::flash('sukses','Data Ppn Berhasil Di simpan');
		return redirect('/ppn');
    }

    public function editform(Request $request) {
		$ppn = Ppn::where('id','=',$request->id)->first();
		if($ppn)
		{
			return \Response::json(\View::make('ppn.editform', array('ppn' => $ppn))->render());
		} 
    }

    public function update()
    {
        $id      = Input::get('id');
        $ppn    = Input::get('ppn');
    	$rate 		= Input::get('rate');
        
        Ppn::where('id',$id)->update([
            'ppn'       =>  $ppn,
            'rate'       =>  $rate,
        ]);
        Session::flash('sukses','Data Ppn Berhasil Di edit');
        return redirect('/ppn');
        
    }
}
