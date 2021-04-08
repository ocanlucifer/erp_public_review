<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\assortment;
use App\Salesorder;
use App\Sizes;
use App\SO_Sizespec;

use Input;
use File;
use Session;
use Auth;

class SO_SizespecsController extends Controller
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

    public function index($id)
    {
        $sizespecs = SO_Sizespec::where('id_sales_order', $id)->get();
        $salesorder = Salesorder::all();
        $getsalesorder = Salesorder::where('id', $id)->first();
        $sizes = Sizes::all();
        $assortment = assortment::all();

        return view('sales_order.sizespecs')->with(compact('sizespecs'))->with(compact('salesorder'))->with(compact('getsalesorder'))->with(compact('sizes'))->with(compact('assortment'));
    }

    public function new()
    {
        $id                         = Input::get('id');
        $id_sales_order            = Input::get('id_sales_order');
        $id_size                    = Input::get('code_size');
        $value                      = Input::get('value');
        $specification              = Input::get('specification');
        $allowance                  = Input::get('allowance');
        $position                   = Input::get('position');
        $unit                       = Input::get('unit');
        SO_Sizespec::create([
            'id'                    =>  strtoupper($id),
            'id_sales_order'        =>  $id_sales_order,
            'id_size'               =>  $id_size,
            'value'                 =>  $value,
            'specification'         =>  $specification,
            'allowance'             =>  $allowance,
            'position'              =>  $position,
            'unit'                  =>  $unit
        ]);

        Session::flash('sukses', 'Data Sizespec Berhasil Di simpan');
        return redirect('/salesorders/sizespecs/' . $id_sales_order);
    }

    public function delete($id)
    {
        $id_sales_order = SO_Sizespec::where('id', $id)->first();
        $id_sales_order = $id_sales_order['id_sales_order'];

        SO_Sizespec::where('id', $id)->delete();
        Session::flash('sukses', 'Data Sizespec berhasil dihapus');
        return redirect('/salesorders/sizespecs/' . $id_sales_order);
    }

    public function edit($id)
    {
        $result = SO_Sizespec::where('id', $id)->first();
        $sizespec = SO_Sizespec::where('id_sales_order', $result->id_sales_order)->get();
        $salesorder = Salesorder::all();

        $getsalesorder = Salesorder::where('id', $result->id_sales_order)->first();
        $sizes = Sizes::all();

        return view('sales_order.sizespecs_edit')->with(compact('result'))->with(compact('sizespec'))->with(compact('salesorder'))->with(compact('getsalesorder'))->with(compact('sizes'));
    }

    public function update()
    {
        $id                         = Input::get('id');
        $id_sales_order             = Input::get('id_sales_order');
        $id_size                    = Input::get('code_size');
        $value                      = Input::get('value');
        $specification              = Input::get('specification');
        $allowance                  = Input::get('allowance');
        $position                   = Input::get('position');
        $unit                       = Input::get('unit');

        SO_Sizespec::where('id', $id)->update([
            'id_sales_order'        =>  $id_sales_order,
            'id_size'               =>  $id_size,
            'value'                 =>  $value,
            'specification'         =>  $specification,
            'allowance'             =>  $allowance,
            'position'              =>  $position,
            'unit'                  =>  $unit
        ]);
        Session::flash('sukses', 'Data Sizespec Berhasil Di edit');
        return redirect('/salesorders/sizespecs/' . $id_sales_order);
    }
}
