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

use Input;
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

        $id                         = Input::get('id');
        $number                     = $nomor;
        $order_date                 = Input::get('order_date');
        $delivery_date              = Input::get('delivery_date');
        $customer                   = strtoupper(Input::get('customer'));
        $agent                      = strtoupper(Input::get('agent'));
        $state                      = 'PENDING';
        $style                      = strtoupper(Input::get('style'));
        $art_number                 = strtoupper(Input::get('art_number'));
        $brand                      = strtoupper(Input::get('brand'));
        $season                     = strtoupper(Input::get('season'));
        $garment_type               = strtoupper(Input::get('garment_type'));
        $style_group                = strtoupper(Input::get('style_group'));
        $sample_type                = strtoupper(Input::get('sample_type'));
        $cust_style_name            = strtoupper(Input::get('cust_style_name'));
        if (Input::get('description') == '') {
            $description = '-';
        } else {
            $description                = Input::get('description');
        }

        if (Input::get('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Input::get('revision_note'));
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
        $id                         = Input::get('id');
        $number                     = Input::get('number');
        $order_date                 = Input::get('order_date');
        $delivery_date              = Input::get('delivery_date');
        $customer                   = strtoupper(Input::get('customer'));
        $agent                      = strtoupper(Input::get('agent'));
        $state                      = strtoupper(Input::get('state'));
        $style                      = strtoupper(Input::get('style'));
        $art_number                 = strtoupper(Input::get('art_number'));
        $brand                      = strtoupper(Input::get('brand'));
        $season                     = strtoupper(Input::get('season'));
        $garment_type               = strtoupper(Input::get('garment_type'));
        $style_group                = strtoupper(Input::get('style_group'));
        $sample_type                = strtoupper(Input::get('sample_type'));
        $cust_style_name            = strtoupper(Input::get('cust_style_name'));
        if (Input::get('description') == '') {
            $description = '-';
        } else {
            $description                = Input::get('description');
        }

        if (Input::get('revision_note') == '') {
            $revision_note = '-';
        } else {
            $revision_note              = strtoupper(Input::get('revision_note'));
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
