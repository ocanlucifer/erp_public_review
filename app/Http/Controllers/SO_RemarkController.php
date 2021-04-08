<?php

namespace App\Http\Controllers;

use App\SO_Remark;
use App\SO_Remarktype;
use App\Salesorder;

use Illuminate\Http\Request;
use Input;
use File;
use Session;
use Auth;

class SO_RemarkController extends Controller
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

    public function index($idsalesorder)
    {
        $remark = SO_Remark::where('id_sales_order', $idsalesorder)->get();
        $remark2 = SO_Remark::where('id_sales_order', $idsalesorder)->count();

        $remarktype = SO_Remarktype::all();
        $salesorder = Salesorder::all();
        $getsalesorder = Salesorder::where('id', $idsalesorder)->first();

        // print_r($remark2);
        return view('sales_order.remark')->with(compact('remark'))->with(compact('remark2'))->with(compact('remarktype'))->with(compact('salesorder'))->with(compact('getsalesorder'));
    }

    public function new($idsalesorder)
    {
        $remarktype = SO_Remarktype::all();

        $no = 0;
        foreach ($remarktype as $rt) :
            $id_remark_type = $rt->id;
            $id_sales_order = $idsalesorder;
            if (Input::get('description' . $no) == '') {
                $description = '-';
            } else {
                $description = Input::get('description' . $no);
            }

            SO_Remark::create([
                'id_remark_type' => $id_remark_type,
                'id_sales_order' => $id_sales_order,
                'description' => $description
            ]);
            $no++;
        endforeach;
        Session::flash('sukses', 'Data Description Remark Berhasil Disimpan');
        return redirect('/salesorders/remark/' . $idsalesorder);
    }

    public function update($idsalesorder)
    {
        $remarktype = SO_Remarktype::all();

        $no = 0;
        foreach ($remarktype as $rt) :
            $name_id = 'id' . $no;

            $id = Input::get($name_id);
            $id_remark_type = $rt->id;
            $id_sales_order = $idsalesorder;
            if (Input::get('description' . $no) == '') {
                $description = '-';
            } else {
                $description = Input::get('description' . $no);
            }

            SO_Remark::where('id', $id)->update([
                'id_remark_type' => $id_remark_type,
                'id_sales_order' => $id_sales_order,
                'description' => $description
            ]);
            $no++;
        endforeach;
        Session::flash('sukses', 'Data Description Remark Berhasil Disimpan');
        return redirect('/salesorders/remark/' . $idsalesorder);
    }
}
