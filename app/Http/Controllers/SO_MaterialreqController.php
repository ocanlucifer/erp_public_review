<?php

namespace App\Http\Controllers;

use App\SO_MaterialDetail;
use App\SO_Materialreq;
use App\SO_Assortment;
use App\SO_Sizespec;
use App\SO_Remark;

use Illuminate\Http\Request;
use Requests;
use File;
use Session;
use Auth;

class SO_MaterialreqController extends Controller
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

    public function index($idsalesorder, Request $request)
    {
        $assortment = SO_Assortment::where('id_sales_order', $idsalesorder)->count();
        $sizespecs = SO_Sizespec::where('id_sales_order', $idsalesorder)->count();
        $remark = SO_Remark::where('id_sales_order', $idsalesorder)->count();

        if (($assortment == 0) || ($sizespecs == 0) || ($remark == 0)) {
            Session::flash('warning', 'Lengkapi breakdown terlebih dahulu.');
        } else {
        }
        $result = SO_Materialreq::orderby('id', 'asc')
            ->where('id_sales_order', $idsalesorder)
            ->paginate(10);

        if ($request->ajax()) {
            $result = SO_Materialreq::where('number', 'like', '%' . $request->keyword . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('sales_order.materialreq_list', array('result' => $result))->render());
            }
        }
        return view('sales_order.materialreq_index', ['result' => $result]);
    }

    public function new($id_sales_order)
    {
        $no = SO_Materialreq::max('number');
        $newnumber = ((int)substr($no, 5));
        $newnumber += 1;
        $huruf = "MR" . $id_sales_order . "-";
        $nomor = $huruf . sprintf("%03s", $newnumber);

        $id                         = Requests::input('id');
        $number                     = $nomor;
        $id_sales_order            = $id_sales_order;
        $id_fabric_construct         = Requests::input('id_fabric_construct');
        $id_fabric_compost          = Requests::input('id_fabric_compost');
        if (Requests::input('fabric_description') == '') {
            $fabric_description = '-';
        } else {
            $fabric_description = Requests::input('fabric_description');
        }
        $budget                     = Requests::input('budget');
        $po_status                  = Requests::input('po_status');
        $state                      = 'pending';
        $id_purchasing              = Auth::user()->id;
        if (Requests::input('note') == '') {
            $note = '-';
        } else {
            $note              = Requests::input('note');
        }

        SO_Materialreq::create([
            'id'                    =>  strtoupper($id),
            'number'                =>  $number,
            'id_sales_order'       =>  $id_sales_order,
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
        return redirect('/salesorders/materialrequirements/' . $id_sales_order);
    }

    public function delete($id, $idsalesorder)
    {
        SO_Materialreq::where('id', $id)->delete();
        Session::flash('sukses', 'Data Material Requirements has been deleted');
        return redirect('/salesorders/materialrequirements/' . $idsalesorder);
    }

    public function edit($id, $id_sales_order)
    {
        $result = SO_Materialreq::where('id', $id)->first();

        return view('sales_order.materialreq_edit')->with(compact('result'));
    }

    public function update($id_sales_order)
    {
        $id                         = Requests::input('id');
        $number                     = Requests::input('number');
        $id_sales_order            = $id_sales_order;
        $id_fabric_construct         = Requests::input('id_fabric_construct');
        $id_fabric_compost          = Requests::input('id_fabric_compost');
        if (Requests::input('fabric_description') == '') {
            $fabric_description = '-';
        } else {
            $fabric_description = Requests::input('fabric_description');
        }
        $budget                     = Requests::input('budget');
        $po_status                  = Requests::input('po_status');
        $state                      = 'pending';
        $id_purchasing              = Auth::user()->id;
        if (Requests::input('note') == '') {
            $note = '-';
        } else {
            $note              = Requests::input('note');
        }
        SO_Materialreq::where('id', $id)->update([
            'number'                =>  $number,
            'id_sales_order'       =>  $id_sales_order,
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
        return redirect('/salesorders/materialrequirements/' . $id_sales_order);
    }

    // The Begining of Material Detail
    public function get_detail()
    {
        $id_matreq = Requests::input('id_matreq');
        $data_detail = SO_MaterialDetail::where('id_material_req', $id_matreq)->get();
        return response()->json($data_detail);
    }

    public function getData()
    {
        $id = Requests::input('id');
        $result = SO_MaterialDetail::where('id', $id)->first();
        return response()->json($result);
    }

    public function tambah_detail(Request $request)
    {
        if ($request->ajax()) {
            $id_sales_order            = $request->input('id_sales_order');
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

            SO_MaterialDetail::create([
                'id_sales_order'            => $id_sales_order,
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
            $id_sales_order            = $request->input('id_sales_order');
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

            SO_MaterialDetail::where('id', $id)->update([
                'id_sales_order'            => $id_sales_order,
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
        // $id = Requests::input('id');
        $id = $request->input('id');
        SO_MaterialDetail::where('id', $id)->delete();

        $result = strtoupper('material data deleted');
        return response()->json($result);
    }
}
