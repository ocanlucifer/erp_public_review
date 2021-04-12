<?php

namespace App\Http\Controllers;

use App\Remark;
use App\Remarktype;
use App\Salessample;

use Illuminate\Http\Request;
use Requests;
use File;
use Session;
use Auth;

class RemarkController extends Controller
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

    public function index($idsalessample)
    {
        $remark = Remark::where('id_sales_sample', $idsalessample)->get();
        $remark2 = Remark::where('id_sales_sample', $idsalessample)->count();

        $remarktype = Remarktype::all();
        $salessample = Salessample::all();
        $getsalessample = Salessample::where('id', $idsalessample)->first();

        return view('sales_sample.remark')->with(compact('remark'))->with(compact('remark2'))->with(compact('remarktype'))->with(compact('salessample'))->with(compact('getsalessample'));
    }

    public function new($idsalessample)
    {
        $remarktype = Remarktype::all();

        $no = 0;
        foreach ($remarktype as $rt) :
            $id_remark_type = $rt->id;
            $id_sales_sample = $idsalessample;
            if (Requests::input('description' . $no) == '') {
                $description = '-';
            } else {
                $description = Requests::input('description' . $no);
            }

            Remark::create([
                'id_remark_type' => $id_remark_type,
                'id_sales_sample' => $id_sales_sample,
                'description' => $description
            ]);
            $no++;
        endforeach;
        Session::flash('sukses', 'Data Description Remark Berhasil Disimpan');
        return redirect('/salessamples/remark/' . $idsalessample);
    }

    public function update($idsalessample)
    {
        $remarktype = Remarktype::all();

        $no = 0;
        foreach ($remarktype as $rt) :
            $name_id = 'id' . $no;

            $id = Requests::input($name_id);
            $id_remark_type = $rt->id;
            $id_sales_sample = $idsalessample;
            if (Requests::input('description' . $no) == '') {
                $description = '-';
            } else {
                $description = Requests::input('description' . $no);
            }

            Remark::where('id', $id)->update([
                'id_remark_type' => $id_remark_type,
                'id_sales_sample' => $id_sales_sample,
                'description' => $description
            ]);
            $no++;
        endforeach;
        Session::flash('sukses', 'Data Description Remark Berhasil Disimpan');
        return redirect('/salessamples/remark/' . $idsalessample);
    }
}
