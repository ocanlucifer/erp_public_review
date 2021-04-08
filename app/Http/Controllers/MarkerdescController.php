<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarkerFabric;
use App\MarkerDesc;

use App\Marker;
use Input;
use File;
use Session;
use Auth;

class MarkerdescController extends Controller
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
        $result = MarkerDesc::where('markerfab_id', $id)->get();
        if ($result) {

            $markerfab = MarkerFabric::where('id', $id)->first();

            return view('markerfabric.index_desc', compact('result'))->with(compact('markerfab'));
        } else {
            return view('markerfabric.index_desc', compact('result'))->with;
        }
    }

    public function new()
    {
        $id                   = Input::get('id');
        $markerfab_id         = Input::get('markerfab_id');
        $width                = Input::get('width');
        $quantity             = Input::get('quantity');
        $consumption          = Input::get('consumption');
        $efficiency           = Input::get('efficiency');
        $qty_unit             = Input::get('qty_unit');
        $act_unit             = Input::get('act_unit');

        MarkerDesc::create([
            'id'                    =>  strtoupper($id),
            'markerfab_id'          =>  $markerfab_id,
            'width'                 =>  $width,
            'quantity'              =>  $quantity,
            'consumption'           =>  $consumption,
            'efficiency'            =>  $efficiency,
            'qty_unit'              =>  $qty_unit,
            'act_unit'              =>  $act_unit
        ]);

        Session::flash('sukses', 'Data Marker Description Berhasil Di simpan');
        return redirect('/markerdesc/' . $markerfab_id);
    }

    public function update()
    {
        $id                   = Input::get('id');
        $markerfab_id         = Input::get('markerfab_id');
        $width                = Input::get('width');
        $quantity             = Input::get('quantity');
        $consumption          = Input::get('consumption');
        $efficiency           = Input::get('efficiency');
        $qty_unit             = Input::get('qty_unit');
        $act_unit             = Input::get('act_unit');

        MarkerDesc::where('id', $id)->update([
            'id'                    =>  $id,
            'markerfab_id'          =>  $markerfab_id,
            'width'                 =>  $width,
            'quantity'              =>  $quantity,
            'consumption'           =>  $consumption,
            'efficiency'            =>  $efficiency,
            'qty_unit'              =>  $qty_unit,
            'act_unit'              =>  $act_unit
        ]);
        Session::flash('sukses', 'Data Marker Description Berhasil Di edit');
        return redirect('/markerdesc/' . $markerfab_id);
    }

    public function delete($id)
    {
        $data = MarkerDesc::where('id', $id)->first();
        $markerfab_id = $data['markerfab_id'];
        MarkerDesc::where('id', $id)->delete();
        Session::flash('sukses', 'Data marker description berhasil dihapus');
        return redirect('/markerdesc/' . $markerfab_id);
    }
}
