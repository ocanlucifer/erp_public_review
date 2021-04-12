<?php

namespace App\Http\Controllers;

use App\Assortment;
use App\Sizespec;
use App\Remark;
use App\Color;
use App\Salessample;
use App\Customer;
use App\Sizes;
use App\Style;
use App\StyleSample;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;


class SalessamplesController extends Controller
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

        $result = Salessample::orderby('number', 'DESC')->paginate(10);
        $customer = Customer::all();
        $style = Style::all();
        $sampleType = StyleSample::all();

        if ($request->ajax()) {
            $result = Salessample::where('number', 'like', '%' . strtoupper($request->number) . '%')
                ->orWhere('agent', 'like', '%' . $request->number . '%')
                // ->where('order_date', 'order_date', '%' . $request->date_order . '%')
                ->orderBy('number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('sales_sample.list', array('result' => $result))->render());
            }
        }

        return view('sales_sample.index', ['result' => $result])->with(compact('customer'))->with(compact('style'))->with(compact('sampleType'));
    }

    public function new()
    {
        $no_sample = Salessample::max('number');
        $no_smpl = ((int)substr($no_sample, 8));
        $no_smpl += 1;

        $year = date('Y');
        $huruf = "SPL" . $year . "-";
        $nomor = $huruf . sprintf("%05s", $no_smpl);

        $id                         = Requests::input('id');
        $number                     = $nomor;
        $order_date                 = Requests::input('order_date');
        $delivery_date              = Requests::input('delivery_date');
        $customer                   = strtoupper(Requests::input('customer'));
        $agent                      = strtoupper(Requests::input('agent'));
        $state                      = 'PENDING';
        $style                      = strtoupper(Requests::input('style'));
        $art_number                 = strtoupper(Requests::input('art_number'));
        $brand                      = strtoupper(Requests::input('brand'));
        $season                     = strtoupper(Requests::input('season'));
        $garment_type               = strtoupper(Requests::input('garment_type'));
        $style_group                = strtoupper(Requests::input('style_group'));
        $sample_type                = strtoupper(Requests::input('sample_type'));
        $cust_style_name            = strtoupper(Requests::input('cust_style_name'));
        if (Requests::input('description') == '') {
            $description = '-';
        } else {
            $description                = Requests::input('description');
        }

        if (Requests::input('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Requests::input('revision_note'));
        }

        Salessample::create([
            'id'                    =>  strtoupper($id),
            'number'                =>  $number,
            'order_date'            =>  $order_date,
            'delivery_date'         =>  $delivery_date,
            'customer'              =>  $customer,
            'agent'                 =>  $agent,
            'state'                 =>  $state,
            'style'                 =>  $style,
            'art_number'            =>  $art_number,
            'brand'                 =>  $brand,
            'season'                =>  $season,
            'garment_type'          =>  $garment_type,
            'style_group'           =>  $style_group,
            'sample_type'           =>  $sample_type,
            'cust_style_name'       =>  $cust_style_name,
            'description'           =>  $description,
            'revision_note'         =>  $revision_note
        ]);

        Session::flash('sukses', 'Data Sample Berhasil Di simpan');
        return redirect('/salessamples');
    }



    public function delete($id)
    {
        Salessample::where('id', $id)->delete();
        // assortment::where('id_sales_sample', $id)->delete();
        // Sizespec::where('id_sales_sample', $id)->delete();
        // Remark::where('id_sales_sample', $id)->delete();
        // Sampleimage::where('id_sales_sample', $id)->delete();
        // Materialreq::where('id_sales_sample', $id)->delete();
        // MaterialDesc::where('id_sales_sample', $id)->delete();
        Session::flash('sukses', 'Data Sample berhasil dihapus');
        return redirect('/salessamples');
    }

    public function edit($id)
    {
        $result = Salessample::where('id', $id)->first();
        $customer = Customer::all();
        $style = Style::all();
        $sampleType = StyleSample::all();

        return view('sales_sample.edit')->with(compact('result'))->with(compact('customer'))->with(compact('style'))->with(compact('sampleType'));
    }

    public function update()
    {
        $id                         = Requests::input('id');
        $number                     = Requests::input('number');
        $order_date                 = Requests::input('order_date');
        $delivery_date              = Requests::input('delivery_date');
        $customer                   = strtoupper(Requests::input('customer'));
        $agent                      = strtoupper(Requests::input('agent'));
        $state                      = strtoupper(Requests::input('state'));
        $style                      = strtoupper(Requests::input('style'));
        $art_number                 = strtoupper(Requests::input('art_number'));
        $brand                      = strtoupper(Requests::input('brand'));
        $season                     = strtoupper(Requests::input('season'));
        $garment_type               = strtoupper(Requests::input('garment_type'));
        $style_group                = strtoupper(Requests::input('style_group'));
        $sample_type                = strtoupper(Requests::input('sample_type'));
        $cust_style_name            = strtoupper(Requests::input('cust_style_name'));
        if (Requests::input('description') == '') {
            $description = '-';
        } else {
            $description                = Requests::input('description');
        }

        if (Requests::input('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Requests::input('revision_note'));
        }

        Salessample::where('id', $id)->update([
            // 'id'                 =>  strtoupper($id),
            'number'                =>  $number,
            'order_date'            =>  $order_date,
            'delivery_date'         =>  $delivery_date,
            'customer'              =>  $customer,
            'agent'                 =>  $agent,
            'state'                 =>  $state,
            'style'                 =>  $style,
            'art_number'            =>  $art_number,
            'brand'                 =>  $brand,
            'season'                =>  $season,
            'garment_type'          =>  $garment_type,
            'style_group'           =>  $style_group,
            'sample_type'           =>  $sample_type,
            'cust_style_name'       =>  $cust_style_name,
            'description'           =>  $description,
            'revision_note'         =>  $revision_note
        ]);

        Session::flash('sukses', 'Data Sample Berhasil Di edit');
        return redirect('/salessamples');
    }
}
