<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Ppn;
use Input;
use File;
use Session;
use Auth; 

class SupplierController extends Controller
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
        $result = Supplier::orderBy('code', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
        $country_name = $request->country;
      	$result = Supplier::where('code','like','%'.strtoupper($request->code).'%')
						->where('nama','like','%'.$request->nama.'%')
						->where('alamat','like','%'.$request->alamat.'%')
						->where('contact_name','like','%'.$request->contact_name.'%')
						->whereHas('country', function($q) use ($country_name) {
						          $q->where('name','like','%'.$country_name.'%');
						        })
						->where('email','like','%'.$request->email.'%')
						->where('bank','like','%'.$request->bank.'%')
						->orderBy('code', 'asc')
						->paginate(10);

    		$result->appends($request->all());
      		if($result)
      		{
        		return \Response::json(\View::make('supplier.list', array('result' => $result))->render());
      		} 
    	}

        return view('supplier.index', ['result'=>$result]);
    }

    public function new()
  	{
  		$ppn = Ppn::orderBy('ppn', 'asc')->get();
  		return view('supplier.new_form',['ppn'=>$ppn]);
  	}

  	public function edit($code)
  	{
  		$ppn = Ppn::orderBy('ppn', 'asc')->get();
  		$supplier = Supplier::where('code',$code)->first();
  		return view('supplier.edit_form',['supplier'=>$supplier,'ppn'=>$ppn]);
  	}

  	public function save(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:30', 'unique:supplier'],
	    	'nama' 				=> ['required', 'string', 'max:60', 'unique:supplier'],
        	'alamat'      		=> ['required', 'string', 'max:255'],
        	'country_code'		=> ['required', 'string', 'max:255'],
	    	'phone' 			=> ['numeric','digits_between:9,13'],
	    	'top' 				=> ['numeric','digits_between:0,3'],
	    	'ppn' 				=> ['numeric','digits_between:0,3'],
	    	'contact_name' 		=> ['required', 'string', 'max:255'],
	    	'npwp' 				=> ['max:50'],
	    	'bank' 				=> ['max:50'],
	    	'currency' 			=> ['required','string'],
	    	'remarks' 			=> ['max:255'],
	    	'created_by' 		=> ['required'],
    	]);
    	if ($request->bank=='') {
	      $bank='-';
	    } else {
	      $bank=strtoupper($request->bank);
	    }
		Supplier::create([
			'code'					=>	strtoupper($request->code),
			'nama'					=>	strtoupper($request->nama),
      		'alamat'        		=>  $request->alamat,
      		'contact_name'  		=>  $request->contact_name,
      		'country_code'  		=>  $request->country_code,
			'phone'				 	=>	$request->phone,
			'top'					=>	$request->top,
			'ppn'					=>	$request->ppn,
			'email'					=>	$request->email,
			'npwp'					=>	$request->npwp,
			'bank'					=>	$bank,
			'rekening'				=>	$request->rekening,
			'currency'				=>	$request->currency,
			'exchange_rate'			=>	$request->exchange_rate,
			'price_term'			=>	$request->price_term,
			'payment_term'			=>	$request->payment_term,
			'remarks'				=>	$request->remarks,
			'created_by'			=>	$request->created_by,
		]);

		Session::flash('sukses','Data Supplier '.strtoupper($request->code).' ('.strtoupper($request->nama).') Berhasil Di simpan');
		return redirect('/supplier');
    }

    public function update(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:30'],
	    	'nama' 				=> ['required', 'string', 'max:60'],
        	'alamat'      		=> ['required', 'string', 'max:255'],
        	'country_code'		=> ['required', 'string', 'max:255'],
	    	'phone' 			=> ['numeric','digits_between:9,13'],
	    	'top' 				=> ['numeric','digits_between:0,3'],
	    	'ppn' 				=> ['numeric','digits_between:0,3'],
	    	'contact_name' 		=> ['required', 'string', 'max:255'],
	    	'npwp' 				=> ['max:50'],
	    	'bank' 				=> ['max:50'],
	    	'currency' 			=> ['required','string'],
	    	'remarks' 			=> ['max:255'],
	    	'updated_by' 		=> ['required'],
    	]);

    	if ($request->bank=='') {
	      $bank='-';
	    } else {
	      $bank=strtoupper($request->bank);
	    }
	    
		Supplier::where('code',$request->code)->update([
			'nama'					=>	strtoupper($request->nama),
      		'alamat'        		=>  $request->alamat,
      		'contact_name'  		=>  $request->contact_name,
      		'country_code'  		=>  $request->country_code,
			'phone'				  	=>	$request->phone,
			'top'					=>	$request->top,
			'ppn'					=>	$request->ppn,
			'email'					=>	$request->email,
			'npwp'					=>	$request->npwp,
			'bank'					=>	$bank,
			'rekening'				=>	$request->rekening,
			'currency'				=>	$request->currency,
			'exchange_rate'			=>	$request->exchange_rate,
			'price_term'			=>	$request->price_term,
			'payment_term'			=>	$request->payment_term,
			'remarks'				=>	$request->remarks,
			'updated_by'			=>	$request->updated_by,
		]);

		Session::flash('sukses','Data Supplier '.strtoupper($request->code).' - '.$request->nama.' Berhasil Di Update');
		return redirect('/supplier');
    }

    public function delete($code)
    {	
    	Supplier::where('code',$code)->delete();
		Session::flash('sukses','Data Supplier '.$code.' berhasil dihapus');
		return redirect('/supplier');
    }
}
