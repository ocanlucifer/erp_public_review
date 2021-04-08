<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Brand;
use Input;
use File;
use Session;
use Auth; 

class BrandController extends Controller
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
        $result = Brand::orderBy('name', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
          	$result = Brand::where('name','like','%'.strtoupper($request->name).'%')
                  ->orderBy('name', 'asc')
                  ->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('brand.list', array('result' => $result))->render());
      		} 
    	}

        return view('brand.index', ['result'=>$result]);
    }

    public function editform(Request $request) {
      $brand = Brand::where('id','=',$request->id)->first();
          if($brand)
          {
            return \Response::json(\View::make('brand.editform', array('brand' => $brand))->render());
          } 
    }

    public function delete($id)
    {	
    	Brand::where('id',$id)->delete();
		Session::flash('sukses','brand berhasil dihapus');
		return redirect('/brand');
    }

    public function new()
    {
    	$name 		= Input::get('name');

		Brand::create([
			'name'			=>	strtoupper($name),
		]);

		Session::flash('sukses','Data brand Berhasil Di simpan');
		return redirect('/brand');
    }

    public function update()
    {
        $id      	= Input::get('id');
        $name    	= Input::get('name');
        Brand::where('id',$id)->update([
            'name'       =>  strtoupper($name),
        ]);
        Session::flash('sukses','Data brand Berhasil Di edit');
        return redirect('/brand');
    }
}
