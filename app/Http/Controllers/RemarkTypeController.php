<?php

namespace App\Http\Controllers;

use App\Remarktype;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;

class RemarkTypeController extends Controller
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

    public function index($id_sales_sample, Request $request)
    {
        $remark_type = Remarktype::orderBy('id', 'asc')
            ->paginate(30);

        if ($request->ajax()) {
            $remark_type = Remarktype::where('id', 'like', '%' . strtoupper($request->id) . '%')
                ->where('name', 'like', '%' . $request->name . '%')
                ->orderBy('id', 'asc')
                ->paginate(30);

            $remark_type->appends($request->all());
            if ($remark_type) {
                return \Response::json(\View::make('sales_sample.remark_type_list', array('remark_type' => $remark_type))->render());
            }
        }

        return view('sales_sample.remark_type')->with(compact('remark_type'));
    }

    public function new($id_sales_sample)
    {
        $id                 = Requests::input('id');
        $name               = Requests::input('name');
        Remarktype::create([
            'id'            => strtoupper($id),
            'name'          => $name
        ]);

        Session::flash('sukses', 'Data Remark Type Berhasil Di simpan');
        return redirect('/salessamples/remark_type/' . $id_sales_sample);
    }

    public function update($id_sales_sample)
    {
        $id                 = Requests::input('id');
        $name               = Requests::input('name');
        Remarktype::where('id', $id)->update([
            'name'           =>  $name,
        ]);
        Session::flash('sukses', 'Data Remark Type Berhasil Di edit');
        return redirect('/salessamples/remark_type/' . $id_sales_sample);
    }

    public function delete($id, $id_sales_sample)
    {
        Remarktype::where('id', $id)->delete();
        Session::flash('sukses', 'Data Remark Type berhasil dihapus');
        return redirect('/salessamples/remark_type/' . $id_sales_sample);
    }
}
