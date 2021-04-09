<?php

namespace App\Http\Controllers;

use App\Salesorder;
use App\Customer;
use App\Quotation;
use App\Style;
use App\StyleSample;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;

class SalesordersController extends Controller
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
        $result = Salesorder::orderby('number', 'DESC')->paginate(10);
        $customer = Customer::all();
        $style = Style::all();
        $sampleType = StyleSample::all();
        $quotation = Quotation::all();

        if ($request->ajax()) {
            $result = Salesorder::where('number', 'like', '%' . strtoupper($request->number) . '%')
                ->orWhere('agent', 'like', '%' . strtoupper($request->number) . '%')
                // ->where('order_date', 'order_date', '%' . $request->date_order . '%')
                ->orderBy('number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('sales_order.list', array('result' => $result))->render());
            }
        }

        return view('sales_order.index', ['result' => $result])->with(compact('customer'))->with(compact('style'))->with(compact('sampleType'))->with(compact('quotation'));
    }

    public function new()
    {
        $no_order = Salesorder::max('number');
        $no_ordr = ((int)substr($no_order, 7));
        $no_ordr += 1;

        $year = date('Y');
        $huruf = "SO" . $year . "-";
        $nomor = $huruf . sprintf("%05s", $no_ordr);

        $id                         = Requests::input('id');
        $number                     = $nomor;
        $code_quotation             = strtoupper(Requests::input('code_quotation'));
        $order_date                 = Requests::input('order_date');
        $delivery_date              = Requests::input('delivery_date');
        $customer                   = strtoupper(Requests::input('customer'));
        $agent                      = strtoupper(Requests::input('agent'));
        $no_consumption             = strtoupper(Requests::input('no_consumption'));
        $state                      = 'pending';
        $style                      = strtoupper(Requests::input('style'));
        $art_number                 = strtoupper(Requests::input('art_number'));
        $brand                      = strtoupper(Requests::input('brand'));
        $season                     = strtoupper(Requests::input('season'));
        $garment_type               = strtoupper(Requests::input('garment_type'));
        $style_group                = strtoupper(Requests::input('style_group'));
        $cust_style_name            = strtoupper(Requests::input('cust_style_name'));
        if (Requests::input('description') == '') {
            $description = '-';
        } else {
            $description              = Requests::input('description');
        }
        if (Requests::input('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Requests::input('revision_note'));
        }

        Salesorder::create([
            'id'                    =>  strtoupper($id),
            'number'                =>  $number,
            'code_quotation'        =>  $code_quotation,
            'order_date'            =>  $order_date,
            'delivery_date'         =>  $delivery_date,
            'customer'              =>  $customer,
            'agent'                 =>  $agent,
            'no_consumption'        =>  $no_consumption,
            'state'                 =>  $state,
            'style'                 =>  $style,
            'art_number'            =>  $art_number,
            'brand'                 =>  $brand,
            'season'                =>  $season,
            'garment_type'          =>  $garment_type,
            'style_group'           =>  $style_group,
            'cust_style_name'       =>  $cust_style_name,
            'description'           =>  $description,
            'revision_note'         =>  $revision_note
        ]);

        Session::flash('sukses', 'Data Order Berhasil Di simpan');
        return redirect('/salesorders');
    }

    public function update()
    {
        $id                         = Requests::input('id');
        $number                     = strtoupper(Requests::input('number'));
        $code_quotation             = strtoupper(Requests::input('code_quotation'));
        $order_date                 = Requests::input('order_date');
        $delivery_date              = Requests::input('delivery_date');
        $customer                   = strtoupper(Requests::input('customer'));
        $agent                      = strtoupper(Requests::input('agent'));
        $no_consumption             = strtoupper(Requests::input('no_consumption'));
        $state                      = strtoupper(Requests::input('state'));
        $style                      = strtoupper(Requests::input('style'));
        $art_number                 = strtoupper(Requests::input('art_number'));
        $brand                      = strtoupper(Requests::input('brand'));
        $season                     = strtoupper(Requests::input('season'));
        $garment_type               = strtoupper(Requests::input('garment_type'));
        $style_group                = strtoupper(Requests::input('style_group'));
        $cust_style_name            = strtoupper(Requests::input('cust_style_name'));
        if (Requests::input('description') == '') {
            $description = '-';
        } else {
            $description              = Requests::input('description');
        }
        if (Requests::input('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Requests::input('revision_note'));
        }
        Salesorder::where('id', $id)->update([
            'number'                =>  $number,
            'code_quotation'        =>  $code_quotation,
            'order_date'            =>  $order_date,
            'delivery_date'         =>  $delivery_date,
            'customer'              =>  $customer,
            'agent'                 =>  $agent,
            'no_consumption'        =>  $no_consumption,
            'state'                 =>  $state,
            'style'                 =>  $style,
            'art_number'            =>  $art_number,
            'brand'                 =>  $brand,
            'season'                =>  $season,
            'garment_type'          =>  $garment_type,
            'style_group'           =>  $style_group,
            'cust_style_name'       =>  $cust_style_name,
            'description'           =>  $description,
            'revision_note'         =>  $revision_note
        ]);
        Session::flash('sukses', 'Data Order Berhasil Di edit');
        return redirect('/salesorders');
    }

    public function delete($id)
    {
        Salesorder::where('id', $id)->delete();
        Session::flash('sukses', 'Data Order berhasil dihapus');
        return redirect('/salesorders');
    }

    public function edit($id)
    {
        $result = Salesorder::where('id', $id)->first();
        $customer = Customer::all();
        $style = Style::all();
        $sampleType = StyleSample::all();

        return view('sales_order.edit')->with(compact('result'))->with(compact('customer'))->with(compact('style'))->with(compact('sampleType'));
    }

    public function detail($id)
    {
        return view('sales_order.detail');
    }

    function getQuotation(Request $request)
    {
        $code = $request->get('query');
        $output = Quotation::where('code', $code)->first();

        return response()->json($output);
    }
}
