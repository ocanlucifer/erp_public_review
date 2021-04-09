<?php

namespace App\Http\Controllers;

use App\Assortment;
use App\Assortment as AppAssortment;
use App\Color;
use App\Salessample;
use App\Customer;
use App\Sizes;
use App\Style;
use App\StyleSample;
use App\Quotation;
use Illuminate\Http\Request;
use Requests;

use Input;
use File;
use Session;
use Auth;

class AssortmentController extends Controller
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
        $assortment = Assortment::where('id_sales_sample', $id)->paginate(10);

        // if (count($assortment) > 0) {
        //     echo 'ok';
        // } else {
        //     echo 'no';
        // }

        $salessample = Salessample::all();
        $getsalessample = Salessample::where('id', $id)->first();
        $sizes = Sizes::all();
        $color = Color::all();

        return view('sales_sample.assortment')->with(compact('assortment'))->with(compact('salessample'))->with(compact('getsalessample'))->with(compact('sizes'))->with(compact('color'));
    }

    public function new()
    {
        $id                         = Requests::input('id');
        $id_sales_sample            = Requests::input('id_sales_sample');
        $id_size                    = Requests::input('code_size');
        $id_color                   = Requests::input('code_color');
        $quantity                   = Requests::input('quantity');
        $tolerance                  = Requests::input('tolerance');
        Assortment::create([
            'id'                    =>  strtoupper($id),
            'id_sales_sample'       =>  $id_sales_sample,
            'id_size'               =>  $id_size,
            'id_color'              =>  $id_color,
            'quantity'              =>  $quantity,
            'tolerance'             =>  $tolerance
        ]);

        Session::flash('sukses', 'Data Assortment Berhasil Di simpan');
        return redirect('/assortment/' . $id_sales_sample);
    }

    public function delete($id)
    {
        $id_sales_sample = Assortment::where('id', $id)->first();
        $id_sales_sample = $id_sales_sample['id_sales_sample'];

        Assortment::where('id', $id)->delete();
        Session::flash('sukses', 'Data assortment berhasil dihapus');
        return redirect('/assortment/' . $id_sales_sample);
    }

    public function edit($id)
    {
        $result = Assortment::where('id', $id)->first();
        $assortment = Assortment::where('id_sales_sample', $result->id_sales_sample)->get();
        $salessample = Salessample::all();
        // $getsalessample = Salessample::where('id', $id)->first();
        $getsalessample = Salessample::where('id', $result->id_sales_sample)->first();
        $sizes = Sizes::all();
        $color = Color::all();


        return view('sales_sample.assortment_edit')->with(compact('result'))->with(compact('assortment'))->with(compact('salessample'))->with(compact('getsalessample'))->with(compact('sizes'))->with(compact('color'));
    }

    public function update()
    {
        $id                         = Requests::input('id');
        $id_sales_sample            = Requests::input('id_sales_sample');
        $id_size                    = Requests::input('code_size');
        $id_color                   = Requests::input('code_color');
        $quantity                   = Requests::input('quantity');
        $tolerance                  = Requests::input('tolerance');

        Assortment::where('id', $id)->update([
            'id_sales_sample'       =>  $id_sales_sample,
            'id_size'               =>  $id_size,
            'id_color'              =>  $id_color,
            'quantity'              =>  $quantity,
            'tolerance'             =>  $tolerance
        ]);
        Session::flash('sukses', 'Data Sample Berhasil Di edit');
        return redirect('/assortment/' . $id_sales_sample);
    }
}
