<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Currencies;
use Requests;
use File;
use Session;
use Auth; 

class CurrenciesController extends Controller
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
        $result = Currencies::orderBy('code', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Currencies::where('code','like','%'.strtoupper($request->code).'%')
                  ->where('nama','like','%'.$request->nama.'%')
                  ->where('sign','like','%'.$request->sign.'%')
                  ->orderBy('code', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('currencies.list', array('result' => $result))->render());
      		} 
    	}

        return view('currencies.index', ['result'=>$result]);
    }

    public function delete($code)
    {	
    	Currencies::where('code',$code)->delete();
		Session::flash('sukses','Currencies berhasil dihapus');
		return redirect('/currencies');
    }

    public function new()
    {
    	$code 		= Requests::input('code');
    	$nama 		= Requests::input('nama');
        $sign       = Requests::input('sign');

		Currencies::create([
			'code'			=>	strtoupper($code),
			'nama'			=>	$nama,
            'sign'          =>  $sign,
		]);

		Session::flash('sukses','Data Currencies Berhasil Di simpan');
		return redirect('/currencies');
    }

    public function update()
    {
        $code      	= Requests::input('code');
        $nama    	= Requests::input('nama');
        $sign       = Requests::input('sign');
        Currencies::where('code',$code)->update([
            'nama'       =>  $nama,
            'sign'       =>  $sign,
        ]);
        Session::flash('sukses','Data Currencies Berhasil Di edit');
        return redirect('/currencies');
    }
}
