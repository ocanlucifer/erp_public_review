<?php

namespace App\Http\Controllers;

use App\Consumption;
use Illuminate\Http\Request;

use Input;
use File;
use Session;
use Auth;

class ConsumptionController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth', 'verified']);

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
        $result = Consumption::orderby('consumptions.id', 'asc')
            ->paginate(10);

        if ($request->ajax()) {
            $result = Consumption::where('code', 'like', '%' . $request->code . '%')
                ->Where('customer', 'like', '%' . $request->customer . '%')
                ->Where('customer_style', 'like', '%' . $request->customer_style . '%')
                ->Where('code_quotation', 'like', '%' . $request->code_quotation . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('consumption.list', array('result' => $result))->render());
            }
        }
        return view('consumption.index', ['result' => $result]);
    }

    public function delete($id)
    {
        Consumption::where('id', $id)->delete();
        Session::flash('sukses', 'Data consumption berhasil dihapus');
        return redirect('/consumption');
    }

    public function create()
    {
        $no = Consumption::max('code');
        $number = ((int)substr($no, 9));
        $number += 1;

        $year = date('Y');
        $nomor = "RKK/" . $year . "/";
        $number = $nomor . sprintf("%05s", $number);

        $id                     = Input::get('id');
        $code                   = $number;
        $code_quotation         = Input::get('code_quotation');
        $customer               = Input::get('customer');
        $customer_style         = strtoupper(Input::get('customer_style'));
        $number_mp              = Input::get('number_mp');
        $size_tengah            = strtoupper(Input::get('size_tengah'));
        $delivery_date          = Input::get('delivery_date');
        $references_date        = Input::get('references_date');
        $net_price              = Input::get('net_price');
        $status                 = strtoupper('pending');

        Consumption::create([
            'code'              =>  $code,
            'code_quotation'    =>  $code_quotation,
            'customer'          =>  $customer,
            'customer_style'    =>  $customer_style,
            'number_mp'         =>  $number_mp,
            'size_tengah'       =>  $size_tengah,
            'delivery_date'     =>  $delivery_date,
            'references_date'   =>  $references_date,
            'net_price'         =>  $net_price,
            'status'            =>  $status
        ]);

        Session::flash('sukses', 'Data Consumption Berhasil Di simpan');
        return redirect('/consumption');
    }

    public function edit($id)
    {
        $result = Consumption::where('id', $id)->first();

        return view('consumption.edit')->with(compact('result'));
    }

    public function update()
    {
        $id                     = Input::get('id');
        $code                   = Input::get('code');
        $code_quotation         = Input::get('code_quotation');
        $customer               = Input::get('customer');
        $customer_style         = strtoupper(Input::get('customer_style'));
        $number_mp              = Input::get('number_mp');
        $size_tengah            = strtoupper(Input::get('size_tengah'));
        $delivery_date          = Input::get('delivery_date');
        $references_date        = Input::get('references_date');
        $net_price              = Input::get('net_price');
        $status                 = Input::get('status');


        Consumption::where('id', $id)->update([
            'code'              =>  $code,
            'code_quotation'    =>  $code_quotation,
            'customer'          =>  $customer,
            'customer_style'    =>  $customer_style,
            'number_mp'         =>  $number_mp,
            'size_tengah'       =>  $size_tengah,
            'delivery_date'     =>  $delivery_date,
            'references_date'   =>  $references_date,
            'net_price'         =>  $net_price,
            'status'            =>  $status
        ]);
        Session::flash('sukses', 'Data Consumption Berhasil Di Update');
        return redirect('/consumption');
    }
}
