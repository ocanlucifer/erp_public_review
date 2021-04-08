<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;
use Input;
use File;
use Session;
use Auth; 

class CustomerController extends Controller
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
        $result = Customer::orderBy('code', 'asc')
            ->paginate(10);
    	

    	if($request->ajax())
    	{
        $country_name = $request->country;
      	$result = Customer::where('code','like','%'.strtoupper($request->code).'%')
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
        		return \Response::json(\View::make('customer.list', array('result' => $result))->render());
      		} 
    	}

        return view('customer.index', ['result'=>$result]);
    }

    public function new()
  	{
  		return view('customer.new_form');
  	}

  	public function edit($code)
  	{
  		$customer = Customer::where('code',$code)->first();
  		return view('customer.edit_form',['customer'=>$customer]);
  	}

  	public function save(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:30', 'unique:customer'],
	    	'nama' 				=> ['required', 'string', 'max:60', 'unique:customer'],
        'alamat'      => ['required', 'string', 'max:255'],
        'country_code'=> ['required', 'string', 'max:255'],
        'contact_name'=> ['required', 'string', 'max:255'],
	    	'phone' 			=> ['numeric','digits_between:9,13'],
	    	'top' 				=> ['numeric','digits_between:0,3'],
	    	'npwp' 				=> ['max:50'],
	    	'bank' 				=> ['max:50'],
	    	'remarks' 		=> ['max:255'],
	    	'created_by' 	=> ['required'],
    	]);

  		// // Get the last order id
    //     $lastCode = Customer::orderBy('code', 'desc')->first();

    //     // Get last 3 digits of last order id
    //     if ($lastCode['code']=='') {
    //     	$lastNumber = 'C' . date('Y') .'-'. str_pad(0, 5, 0, STR_PAD_LEFT);
    //     } else {
    //     	$lastNumber = $lastCode['code'];
    //     }
    //     $lastIncreament = substr($lastNumber, -5);

    //     // Make a new order id with appending last increment + 1
    //     $newCode = 'C' . date('Y') .'-'. str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);
    
    if ($request->bank=='') {
      $bank='-';
    } else {
      $bank=strtoupper($request->bank);
    }
		Customer::create([
      // 'code'          =>  $newCode,
			'code'					=>	strtoupper($request->code),
			'nama'					=>	strtoupper($request->nama),
      'alamat'        =>  $request->alamat,
      'contact_name'  =>  $request->contact_name,
      'country_code'  =>  $request->country_code,
			'phone'				  =>	$request->phone,
			'top'					  =>	$request->top,
			'email'					=>	$request->email,
			'npwp'					=>	$request->npwp,
			'bank'					=>	$bank,
			'rekening'			=>	$request->rekening,
			'remarks'				=>	$request->remarks,
			'created_by'		=>	$request->created_by,
		]);

		Session::flash('sukses','Data Customer '.strtoupper($request->code).' ('.strtoupper($request->nama).') Berhasil Di simpan');
		return redirect('/customer');
    }

    public function update(Request $request)
    {
    	$this->validate($request,[
    		'code' 				=> ['required', 'string', 'max:30'],
	    	'nama' 				=> ['required', 'string', 'max:60'],
        'alamat'      => ['required', 'string', 'max:255'],
        'country_code'=> ['required', 'string', 'max:255'],
        'contact_name'=> ['required', 'string', 'max:255'],
	    	'phone' 			=> ['numeric','digits_between:9,13'],
	    	'top' 				=> ['numeric','digits_between:0,3'],
	    	'npwp' 				=> ['max:50'],
	    	'bank' 				=> ['max:50'],
	    	'remarks' 		=> ['max:255'],
	    	'updated_by' 	=> ['required'],
    	]);


    if ($request->bank=='') {
      $bank='-';
    } else {
      $bank=strtoupper($request->bank);
    }
		Customer::where('code',$request->code)->update([
			'nama'					=>	strtoupper($request->nama),
      'alamat'        =>  $request->alamat,
      'contact_name'  =>  $request->contact_name,
      'country_code'  =>  $request->country_code,
			'phone'				  =>	$request->phone,
			'top'					  =>	$request->top,
			'email'					=>	$request->email,
			'npwp'					=>	$request->npwp,
			'bank'					=>	$bank,
			'rekening'			=>	$request->rekening,
			'remarks'				=>	$request->remarks,
			'updated_by'		=>	$request->updated_by,
		]);

		Session::flash('sukses','Data Customer '.strtoupper($request->code).' - '.$request->nama.' Berhasil Di Update');
		return redirect('/customer');
    }

    public function delete($code)
    {	
    	Customer::where('code',$code)->delete();
		Session::flash('sukses','Data Customer '.$code.' berhasil dihapus');
		return redirect('/customer');
    }
}
