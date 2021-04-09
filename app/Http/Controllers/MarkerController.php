<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Marker;
use Requests;
use File;
use Session;
use Auth;

class MarkerController extends Controller
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
        $result = Marker::orderBy('id', 'asc')
            ->paginate(10);


        if ($request->ajax()) {
            $result = Marker::where('id', 'like', '%' . strtoupper($request->id) . '%')
                ->where('nama_marker', 'like', '%' . $request->name . '%')
                ->where('style', 'like', '%' . $request->style . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('marker.list', array('result' => $result))->render());
            }
        }

        return view('marker.index', ['result' => $result]);
    }

    public function delete($id)
    {
        Marker::where('id', $id)->delete();
        Session::flash('sukses', 'Data marker berhasil dihapus');
        return redirect('/marker');
    }

    public function new()
    {
        $id                 = Requests::input('id');
        $nama               = Requests::input('nama_marker');
        $style              = Requests::input('style');
        $no_document        = 'CM-MARK-' . $id;
        $date               = date("Y-m-d");

        Marker::create([
            'id'                    =>  strtoupper($id),
            'nama_marker'           =>  $nama,
            'style'                 =>  $style,
            'no_document'           =>  $no_document,
            'date'                  =>  $date
        ]);

        Session::flash('sukses', 'Data Marker Berhasil Di simpan');
        return redirect('/marker');
    }

    public function update()
    {
        $id                 = Requests::input('id');
        $name               = Requests::input('nama_marker');
        $style              = Requests::input('style');
        $no_document        = 'CM-MARK-' . $id;
        Marker::where('id', $id)->update([
            'nama_marker'           =>  $name,
            'style'                 =>  $style,
            'no_document'           =>  $no_document
        ]);
        Session::flash('sukses', 'Data Marker Berhasil Di edit');
        return redirect('/marker');
    }
}
