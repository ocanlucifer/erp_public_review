<?php

namespace App\Http\Controllers;

use App\SO_Assortment;
use App\Color;
use App\Salesorder;
use App\Sizes;
use App\Quotation;
use Illuminate\Http\Request;

use Input;
use File;
use Session;
use Auth;

class SO_AssortmentController extends Controller
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
        $assortment = SO_Assortment::where('id_sales_order', $id)->paginate(10);

        $salesorders = Salesorder::all();
        $sizes = Sizes::all();
        $color = Color::all();
        $getsalesorders = Salesorder::where('id', $id)->first();

        // mendapatkan nilai quantity yang di input di quotation
        $code_quo = $getsalesorders['code_quotation'];
        $quot = Quotation::where('code', $code_quo)->first();
        $max_qty = $quot->forecast_qty;

        // menghitung jumlah quantity assortment yang telah diinput
        $assort = SO_Assortment::where('id_sales_order', $id)->get();
        $qty = 0;
        foreach ($assort as $ass) {
            $qty += $ass['quantity'];
        }

        // menghitung jumlah quantity yang memungkinkan agar tidak melebihi quantity di Quotation
        $qty_avail = $max_qty - $qty;

        return view('sales_order.assortment')->with(compact('assortment'))->with(compact('salesorders'))->with(compact('getsalesorders'))->with(compact('sizes'))->with(compact('color'))->with(compact('max_qty'))->with(compact('qty'))->with(compact('qty_avail'));
    }

    public function new()
    {
        $id_sales_order                 = Input::get('id_sales_order');

        // cek size dengan warna yang sama sudah pernah diinput atau tidak
        $color_cek                      = Input::get('code_color');
        $size_cek                       = Input::get('code_size');
        $colorsize_cek = SO_Assortment::where('id_color', $color_cek)->where('id_size', $size_cek)->count();

        if ($colorsize_cek > 0) {
            Session::flash('error', 'Warna dan Size yang sama sudah ada.');
        } else {
            $qty_cek = Input::get('quantity');
            // cek input quantity tidak boleh 0 atau minus
            if ($qty_cek <= 0) {
                Session::flash('error', 'Quantity tidak boleh 0 atau kurang dari 0');
            } else {
                // input data ke database
                $id                         = Input::get('id');
                $id_sales_order             = Input::get('id_sales_order');
                $id_size                    = Input::get('code_size');
                $id_color                   = Input::get('code_color');
                $quantity                   = Input::get('quantity');
                $tolerance                  = Input::get('tolerance');
                SO_Assortment::create([
                    'id'                    =>  strtoupper($id),
                    'id_sales_order'        =>  $id_sales_order,
                    'id_size'               =>  $id_size,
                    'id_color'              =>  $id_color,
                    'quantity'              =>  $quantity,
                    'tolerance'             =>  $tolerance
                ]);

                Session::flash('sukses', 'Data Assortment Berhasil Di simpan');
            }
        }
        return redirect('/so_assortment/' . $id_sales_order);
    }

    public function delete($id)
    {
        $assortment = SO_Assortment::where('id', $id)->first();
        $id_sales_order = $assortment['id_sales_order'];

        SO_Assortment::where('id', $id)->delete();
        Session::flash('sukses', 'Data assortment berhasil dihapus');
        return redirect('/so_assortment/' . $id_sales_order);
    }

    public function edit($id)
    {
        $result = SO_Assortment::where('id', $id)->first();
        $assortment = SO_Assortment::where('id_sales_order', $result->id_sales_order)->get();
        $salesorder = Salesorder::all();
        $getsalesorder = Salesorder::where('id', $result->id_sales_order)->first();
        $sizes = Sizes::all();
        $color = Color::all();


        return view('sales_order.assortment_edit')->with(compact('result'))->with(compact('assortment'))->with(compact('salesorder'))->with(compact('getsalesorder'))->with(compact('sizes'))->with(compact('color'));
    }

    public function update()
    {
        $id                             = Input::get('id');
        $id_sales_order                 = Input::get('id_sales_order');

        // cek apakah size dan warna yang sama sudah di table?
        $color_input                      = Input::get('code_color');
        $size_input                       = Input::get('code_size');
        $colorsize_cek = SO_Assortment::where('id_color', $color_input)->where('id_size', $size_input)->count();
        $old_data = SO_Assortment::where('id', $id)->first();
        $new_data = SO_Assortment::where('id_color', $color_input)->where('id_size', $size_input)->first();

        // cek apakah sudah ada data dengan color dan size yang sama? bisa jadi data itu adalah data lama
        if ($colorsize_cek > 0) {

            // cek apakah size sama dengan data sebelumnya?
            if ($new_data['id_size'] == $old_data['id_size']) {

                // cek apakah warna sama dengan data sebelumnya?
                if ($new_data['id_color'] == $old_data['id_color']) {
                    $qty_cek = Input::get('quantity');

                    // cek input quantity tidak boleh 0 atau minus
                    if ($qty_cek <= 0) {
                        Session::flash('error', 'Quantity tidak boleh 0 atau kurang dari 0.');
                    } else {
                        $id                         = Input::get('id');
                        $id_sales_order             = Input::get('id_sales_order');
                        $id_size                    = Input::get('code_size');
                        $id_color                   = Input::get('code_color');
                        $quantity                   = Input::get('quantity');
                        $tolerance                  = Input::get('tolerance');

                        // cek input quantity tidak boleh melebihi avail quantity
                        $getsalesorders = Salesorder::where('id', $id_sales_order)->first();

                        // mendapatkan nilai quantity yang di input di quotation
                        $code_quo = $getsalesorders['code_quotation'];
                        $quot = Quotation::where('code', $code_quo)->first();
                        $max_qty = $quot->forecast_qty;

                        // menghitung jumlah quantity assortment yang telah diinput
                        $assort = SO_Assortment::where('id_sales_order', $id_sales_order)->get();
                        $qty = 0;
                        foreach ($assort as $ass) {
                            $qty += $ass['quantity'];
                        }

                        // mendapatkan nilai quantity yang available agar tidak melebihi jumlah di quotation
                        $qty_avail = $max_qty - $qty + $old_data['quantity'];

                        // menghitung jumlah quantity yang memungkinkan agar tidak melebihi quantity di Quotation
                        if ($qty_cek > $qty_avail) {
                            Session::flash('error', 'Jumlah quantity melebihi quantity yang ada di quotation.');
                        } else {

                            SO_Assortment::where('id', $id)->update([
                                'id_sales_order'        =>  $id_sales_order,
                                'id_size'               =>  $id_size,
                                'id_color'              =>  $id_color,
                                'quantity'              =>  $quantity,
                                'tolerance'             =>  $tolerance
                            ]);
                            Session::flash('sukses', 'Data Sample Berhasil Di edit.');
                        }
                    }
                } else {

                    // gagal update karena yang di update bukanlah data sebelumnya
                    Session::flash('error', 'Gagal update data. kombinasi warna dan size sudah ada.');
                }
            } else {

                // gagal update karena yang di edit bukanlah data sebelumnya
                Session::flash('error', 'Gagal update data. kombinasi warna dan size sudah ada.');
            }
        } else {
            $qty_cek = Input::get('quantity');

            // cek input quantity tidak boleh 0 atau minus
            if ($qty_cek <= 0) {
                Session::flash('error', 'Quantity tidak boleh 0 atau kurang dari 0.');
            } else {

                $id                         = Input::get('id');
                $id_sales_order             = Input::get('id_sales_order');
                $id_size                    = Input::get('code_size');
                $id_color                   = Input::get('code_color');
                $quantity                   = Input::get('quantity');
                $tolerance                  = Input::get('tolerance');

                // cek input quantity tidak boleh melebihi avail quantity
                $getsalesorders = Salesorder::where('id', $id_sales_order)->first();

                // mendapatkan nilai quantity yang di input di quotation
                $code_quo = $getsalesorders['code_quotation'];
                $quot = Quotation::where('code', $code_quo)->first();
                $max_qty = $quot->forecast_qty;

                // menghitung jumlah quantity assortment yang telah diinput
                $assort = SO_Assortment::where('id_sales_order', $id_sales_order)->get();
                $qty = 0;
                foreach ($assort as $ass) {
                    $qty += $ass['quantity'];
                }

                // menghitung jumlah quantity yang memungkinkan agar tidak melebihi quantity di Quotation
                $qty_avail = $max_qty - $qty + $old_data['quantity'];

                if ($qty_cek > $qty_avail) {
                    Session::flash('error', 'Jumlah quantity melebihi quantity yang ada di quotation.');
                } else {
                    SO_Assortment::where('id', $id)->update([
                        'id_sales_order'        =>  $id_sales_order,
                        'id_size'               =>  $id_size,
                        'id_color'              =>  $id_color,
                        'quantity'              =>  $quantity,
                        'tolerance'             =>  $tolerance
                    ]);
                    Session::flash('sukses', 'Data Sample Berhasil Di edit.');
                }
            }
        }
        return redirect('/so_assortment/' . $id_sales_order);
    }
}
