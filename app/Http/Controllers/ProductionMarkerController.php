<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductionMarker;
use Requests;
use File;
use Session;
use Auth;

class ProductionMarkerController extends Controller
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
        $result = ProductionMarker::orderBy('id', 'asc')
            ->paginate(10);


        if ($request->ajax()) {
            $result = ProductionMarker::where('id', 'like', '%' . strtoupper($request->id) . '%')
                ->where('style_name', 'like', '%' . $request->style_name . '%')
                ->where('order_name', 'like', '%' . $request->order_name . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('promark.list', array('result' => $result))->render());
            }
        }

        return view('promark.index', ['result' => $result]);
    }

    public function new()
    {
        $id         = Requests::input('id');
        $number = Requests::input('number');
        $style_name       = Requests::input('style_name');
        $order_name       = Requests::input('order_name');

        ProductionMarker::create([
            'id'            =>    strtoupper($id),
            'number'            =>    $number,
            'style_name'          =>  $style_name,
            'order_name'          =>  $order_name
        ]);

        Session::flash('sukses', 'Data Production Marker Berhasil Di simpan');
        return redirect('/promark');
    }

    public function update()
    {
        $id          = Requests::input('id');
        $number        = Requests::input('number');
        $style_name       = Requests::input('style_name');
        $order_name       = Requests::input('order_name');

        ProductionMarker::where('id', $id)->update([
            'number'       =>  $number,
            'style_name'       =>  $style_name,
            'order_name'       =>  $order_name,
        ]);
        Session::flash('sukses', 'Data Production Marker Berhasil Di edit');
        return redirect('/promark');
    }

    public function delete($id)
    {
        ProductionMarker::where('id', $id)->delete();
        Session::flash('sukses', 'Data production marker berhasil dihapus');
        return redirect('/promark');
    }
}
