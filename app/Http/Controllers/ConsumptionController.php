<?php

namespace App\Http\Controllers;

use App\Consumption;
use Illuminate\Http\Request;

use Requests;
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

        $id                     = Requests::input('id');
        $code                   = $number;
        $code_quotation         = Requests::input('code_quotation');
        $customer               = Requests::input('customer');
        $customer_style         = strtoupper(Requests::input('customer_style'));
        $number_mp              = Requests::input('number_mp');
        $size_tengah            = strtoupper(Requests::input('size_tengah'));
        $delivery_date          = Requests::input('delivery_date');
        $references_date        = Requests::input('references_date');
        $net_price              = Requests::input('net_price');
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
        $id                     = Requests::input('id');
        $code                   = Requests::input('code');
        $code_quotation         = Requests::input('code_quotation');
        $customer               = Requests::input('customer');
        $customer_style         = strtoupper(Requests::input('customer_style'));
        $number_mp              = Requests::input('number_mp');
        $size_tengah            = strtoupper(Requests::input('size_tengah'));
        $delivery_date          = Requests::input('delivery_date');
        $references_date        = Requests::input('references_date');
        $net_price              = Requests::input('net_price');
        $status                 = Requests::input('status');


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
