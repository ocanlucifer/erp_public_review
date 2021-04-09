<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perusahaan;
use Requests;
use File;
use Session;
use Auth; 

class PerusahaanController extends Controller
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
        $result = Perusahaan::orderBy('kd_perusahaan', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Perusahaan::where('kd_perusahaan','like','%'.strtoupper($request->kd_perusahaan).'%')
                  ->where('nama_perusahaan','like','%'.$request->nama_perusahaan.'%')
                  ->where('alamat','like','%'.$request->alamat.'%')
                  ->orderBy('kd_perusahaan', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('perusahaan.list', array('result' => $result))->render());
      		} 
    	}

        return view('perusahaan.index', ['result'=>$result]);
    }

    public function delete($kd_perusahaan)
    {	
    	$logo = Perusahaan::where('kd_perusahaan',$kd_perusahaan)->get();
      	foreach ($logo as $l) {
      		File::delete($l->logo);
      	}
    	Perusahaan::where('kd_perusahaan',$kd_perusahaan)->delete();
		Session::flash('sukses','Perusahaan berhasil dihapus');
		return redirect('/perusahaan');
    }

    public function new()
    {
    	$kd_perusahaan 		= Requests::input('kd_perusahaan');
    	$nama_perusahaan 	= Requests::input('nama_perusahaan');
        $alamat             = Requests::input('alamat');
    	$phone 			    = Requests::input('phone');
    	$file 				= Input::file('logo');

    	if ($file) {
    		$folder_upload 	= 'logo-perusahaan/';
    		$nama_file = $file->getClientOriginalName();
			$file->move($folder_upload,$nama_file);

			Perusahaan::create([
				'kd_perusahaan'			=>	strtoupper($kd_perusahaan),
				'nama_perusahaan'		=>	$nama_perusahaan,
                'alamat'                =>  $alamat,
				'phone'				    =>	$phone,
				'logo'					=>	$folder_upload.''.$nama_file,
			]);

			Session::flash('sukses','Data Perusahaan Berhasil Di simpan');
			return redirect('/perusahaan');
    	}
    }

    public function update()
    {
        $kd_perusahaan      = Requests::input('kd_perusahaan');
        $nama_perusahaan    = Requests::input('nama_perusahaan');
        $alamat             = Requests::input('alamat');
        $phone              = Requests::input('phone');
        $file               = Input::file('logo');
        if ($file) {
            $logo = Perusahaan::where('kd_perusahaan',$kd_perusahaan)->get();
            foreach ($logo as $l) {
                File::delete($l->logo);
            }

            $folder_upload  = 'logo-perusahaan/';
            $nama_file = $file->getClientOriginalName();
            $file->move($folder_upload,$nama_file);

            Perusahaan::where('kd_perusahaan',$kd_perusahaan)->update([
                'nama_perusahaan'       =>  $nama_perusahaan,
                'alamat'                =>  $alamat,
                'phone'                 =>  $phone,
                'logo'                  =>  $folder_upload.''.$nama_file,
            ]);
            Session::flash('sukses','Data Perusahaan Berhasil Di edit');
            return redirect('/perusahaan');
        } else {
            Perusahaan::where('kd_perusahaan',$kd_perusahaan)->update([
                'nama_perusahaan'       =>  $nama_perusahaan,
                'alamat'                =>  $alamat,
                'phone'                 =>  $phone,
            ]);
            Session::flash('sukses','Data Perusahaan Berhasil Di edit');
            return redirect('/perusahaan');
        }
    }
}
