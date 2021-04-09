<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assortment;
use App\Salessample;
use App\Sizes;
use App\Sizespec;

use Requests;
use File;
use Session;
use Auth;

class SizespecsController extends Controller
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
        $sizespecs = Sizespec::where('id_sales_sample', $id)->get();
        $salessample = Salessample::all();
        $getsalessample = Salessample::where('id', $id)->first();
        $sizes = Sizes::all();
        $assortment = Assortment::all();

        return view('sales_sample.sizespecs')->with(compact('sizespecs'))->with(compact('salessample'))->with(compact('getsalessample'))->with(compact('sizes'))->with(compact('assortment'));
    }

    public function new()
    {
        $id                         = Requests::input('id');
        $id_sales_sample            = Requests::input('id_sales_sample');
        $id_size                    = Requests::input('code_size');
        $value                      = Requests::input('value');
        $specification              = Requests::input('specification');
        $allowance                  = Requests::input('allowance');
        $position                   = Requests::input('position');
        $unit                       = Requests::input('unit');
        Sizespec::create([
            'id'                    =>  strtoupper($id),
            'id_sales_sample'       =>  $id_sales_sample,
            'id_size'               =>  $id_size,
            'value'                 =>  $value,
            'specification'         =>  $specification,
            'allowance'             =>  $allowance,
            'position'              =>  $position,
            'unit'                  =>  $unit
        ]);

        Session::flash('sukses', 'Data Sizespec Berhasil Di simpan');
        return redirect('/salessamples/sizespecs/' . $id_sales_sample);
    }

    public function delete($id)
    {
        $id_sales_sample = Sizespec::where('id', $id)->first();
        $id_sales_sample = $id_sales_sample['id_sales_sample'];

        Sizespec::where('id', $id)->delete();
        Session::flash('sukses', 'Data Sizespec berhasil dihapus');
        return redirect('/salessamples/sizespecs/' . $id_sales_sample);
    }

    public function edit($id)
    {
        $result = Sizespec::where('id', $id)->first();
        $sizespec = Sizespec::where('id_sales_sample', $result->id_sales_sample)->get();
        $salessample = Salessample::all();

        $getsalessample = Salessample::where('id', $result->id_sales_sample)->first();
        $sizes = Sizes::all();

        return view('sales_sample.sizespecs_edit')->with(compact('result'))->with(compact('sizespec'))->with(compact('salessample'))->with(compact('getsalessample'))->with(compact('sizes'));
    }

    public function update()
    {
        $id                         = Requests::input('id');
        $id_sales_sample            = Requests::input('id_sales_sample');
        $id_size                    = Requests::input('code_size');
        $value                      = Requests::input('value');
        $specification              = Requests::input('specification');
        $allowance                  = Requests::input('allowance');
        $position                   = Requests::input('position');
        $unit                       = Requests::input('unit');

        Sizespec::where('id', $id)->update([
            'id_sales_sample'       =>  $id_sales_sample,
            'id_size'               =>  $id_size,
            'value'                 =>  $value,
            'specification'         =>  $specification,
            'allowance'             =>  $allowance,
            'position'              =>  $position,
            'unit'                  =>  $unit
        ]);
        Session::flash('sukses', 'Data Sizespec Berhasil Di edit');
        return redirect('/salessamples/sizespecs/' . $id_sales_sample);
    }
}
