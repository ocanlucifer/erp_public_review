<?php

namespace App\Http\Controllers;

use App\Salessample;
use App\Materialreq;
use App\MaterialDetail;
use App\Fabricconst;
use App\Fabriccomp;
use App\User;

use Illuminate\Http\Request;
use Input;
use File;
use Session;
use Auth;

class MaterialreqController extends Controller
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

    public function index($idsalessample, Request $request)
    {
        $result = Materialreq::orderby('id', 'asc')
            ->where('id_sales_sample', $idsalessample)
            ->paginate(10);

        if ($request->ajax()) {
            $result = Materialreq::where('number', 'like', '%' . $request->keyword . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('sales_sample.materialreq_list', array('result' => $result))->render());
            }
        }

        return view('sales_sample.materialreq_index', ['result' => $result]);
    }

    public function new($id_sales_sample)
    {
        $no = Materialreq::max('number');
        $newnumber = ((int)substr($no, 5));
        $newnumber += 1;
        $huruf = "MR" . $id_sales_sample . "-";
        $nomor = $huruf . sprintf("%03s", $newnumber);

        $id                         = Input::get('id');
        $number                     = $nomor;
        $id_sales_sample            = $id_sales_sample;
        $id_fabric_construct         = Input::get('id_fabric_construct');
        $id_fabric_compost          = Input::get('id_fabric_compost');
        if (Input::get('fabric_description') == '') {
            $fabric_description = '-';
        } else {
            $fabric_description = Input::get('fabric_description');
        }
        $budget                     = Input::get('budget');
        $po_status                  = Input::get('po_status');
        $state                      = 'pending';
        $id_purchasing              = Auth::user()->id;
        if (Input::get('note') == '') {
            $note = '-';
        } else {
            $note              = Input::get('note');
        }

        Materialreq::create([
            'id'                    =>  strtoupper($id),
            'number'                =>  $number,
            'id_sales_sample'       =>  $id_sales_sample,
            'id_fabric_construct'   =>  $id_fabric_construct,
            'id_fabric_compost'     =>  $id_fabric_compost,
            'fabric_description'    =>  $fabric_description,
            'budget'                =>  $budget,
            'po_status'             =>  $po_status,
            'state'                 =>  $state,
            'id_purchasing'         =>  $id_purchasing,
            'note'                  =>  $note
        ]);

        Session::flash('sukses', 'Data Material Requirements Berhasil Di simpan');
        return redirect('/salessamples/materialrequirements/' . $id_sales_sample);
    }

    public function delete($id, $idsalessample)
    {
        Materialreq::where('id', $id)->delete();
        Session::flash('sukses', 'Data Material Requirements has been deleted');
        return redirect('/salessamples/materialrequirements/' . $idsalessample);
    }

    public function edit($id, $id_sales_sample)
    {
        $result = Materialreq::where('id', $id)->first();

        return view('sales_sample.materialreq_edit')->with(compact('result'));
    }

    public function update($id_sales_sample)
    {
        $id                         = Input::get('id');
        $number                     = Input::get('number');
        $id_sales_sample            = $id_sales_sample;
        $id_fabric_construct         = Input::get('id_fabric_construct');
        $id_fabric_compost          = Input::get('id_fabric_compost');
        if (Input::get('fabric_description') == '') {
            $fabric_description = '-';
        } else {
            $fabric_description = Input::get('fabric_description');
        }
        $budget                     = Input::get('budget');
        $po_status                  = Input::get('po_status');
        $state                      = 'pending';
        $id_purchasing              = Auth::user()->id;
        if (Input::get('note') == '') {
            $note = '-';
        } else {
            $note              = Input::get('note');
        }
        Materialreq::where('id', $id)->update([
            'number'                =>  $number,
            'id_sales_sample'       =>  $id_sales_sample,
            'id_fabric_construct'   =>  $id_fabric_construct,
            'id_fabric_compost'     =>  $id_fabric_compost,
            'fabric_description'    =>  $fabric_description,
            'budget'                =>  $budget,
            'po_status'             =>  $po_status,
            'state'                 =>  $state,
            'id_purchasing'         =>  $id_purchasing,
            'note'                  =>  $note
        ]);
        Session::flash('sukses', 'Edit Data Material Reuirements Successed');
        return redirect('/salessamples/materialrequirements/' . $id_sales_sample);
    }


    // The Begining of Material Detail
    public function get_detail()
    {
        $id_matreq = Input::post('id_matreq');
        $data_detail = MaterialDetail::where('id_material_req', $id_matreq)->get();
        return response()->json($data_detail);
    }

    public function getData()
    {
        $id = Input::post('id');
        $result = MaterialDetail::where('id', $id)->first();
        return response()->json($result);
    }

    public function tambah_detail(Request $request)
    {
        if ($request->ajax()) {
            $id_sales_sample            = $request->input('id_sales_sample');
            $id_material_req            = $request->input('id_material_req');
            $gmt_color                  = $request->input('gmt_color');
            $gmt_size                   = $request->input('gmt_size');
            $mat_color                  = $request->input('mat_color');
            $mat_size                   = $request->input('mat_size');
            $quantity                   = $request->input('quantity');
            $consumption                = $request->input('consumption');
            $per_garment                = $request->input('per_garment');
            $unit                       = $request->input('unit');
            $wastage                    = $request->input('wastage');
            $status                     = $request->input('status');
            if ($request->input('note') == '') {
                $note = '-';
            } else {
                $note = $request->input('note');
            }

            MaterialDetail::create([
                'id_sales_sample'            => $id_sales_sample,
                'id_material_req'            => $id_material_req,
                'gmt_color'                  => $gmt_color,
                'gmt_size'                   => $gmt_size,
                'mat_color'                  => $mat_color,
                'mat_size'                   => $mat_size,
                'quantity'                   => $quantity,
                'consumption'                => $consumption,
                'per_garment'                => $per_garment,
                'unit'                       => $unit,
                'wastage'                    => $wastage,
                'status'                     => $status,
                'note'                       => $note
            ]);
            $result = strtoupper('new material detail added');
            return response()->json($result);
        }
    }

    public function update_detail(Request $request)
    {
        if ($request->ajax()) {
            $id                         = $request->input('id');
            $id_sales_sample            = $request->input('id_sales_sample');
            $id_material_req            = $request->input('id_material_req');
            $gmt_color                  = $request->input('gmt_color');
            $gmt_size                   = $request->input('gmt_size');
            $mat_color                  = $request->input('mat_color');
            $mat_size                   = $request->input('mat_size');
            $quantity                   = $request->input('quantity');
            $consumption                = $request->input('consumption');
            $per_garment                = $request->input('per_garment');
            $unit                       = $request->input('unit');
            $wastage                    = $request->input('wastage');
            $status                     = $request->input('status');
            if ($request->input('note') == '') {
                $note = '-';
            } else {
                $note = $request->input('note');
            }

            MaterialDetail::where('id', $id)->update([
                'id_sales_sample'            => $id_sales_sample,
                'id_material_req'            => $id_material_req,
                'gmt_color'                  => $gmt_color,
                'gmt_size'                   => $gmt_size,
                'mat_color'                  => $mat_color,
                'mat_size'                   => $mat_size,
                'quantity'                   => $quantity,
                'consumption'                => $consumption,
                'per_garment'                => $per_garment,
                'unit'                       => $unit,
                'wastage'                    => $wastage,
                'status'                     => $status,
                'note'                       => $note
            ]);

            $result = strtoupper('material data updated');
            return response()->json($result);
        }
    }

    public function hapus_detail(Request $request)
    {
        // $id = Input::get('id');
        $id = $request->input('id');
        MaterialDetail::where('id', $id)->delete();

        $result = strtoupper('material data deleted');
        return response()->json($result);
    }
}
