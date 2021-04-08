<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Divisi;
use Input;
use Session;
use Auth;

class DivisiController extends Controller
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
        $result = Divisi::orderBy('id', 'asc')
            ->paginate(10);


        if ($request->ajax()) {
            $result = Divisi::where('nama_divisi', 'like', '%' . strtoupper($request->nama_divisi) . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('divisi.list', array('result' => $result))->render());
            }
        }

        return view('divisi.index', ['result' => $result]);
    }

    public function delete($id)
    {
        Divisi::where('id', $id)->delete();
        Session::flash('sukses', 'Divisi berhasil dihapus');
        return redirect('/divisi');
    }

    public function new()
    {
        $nama_divisi     = Input::get('nama_divisi');
        Divisi::create([
            'nama_divisi'        =>    strtoupper($nama_divisi),
        ]);
        Session::flash('sukses', 'Nama Divisi Berhasil Di simpan');
        return redirect('/divisi');
    }

    public function update()
    {
        $id             = Input::get('id');
        $nama_divisi     = Input::get('nama_divisi');
        Divisi::where('id', $id)->update([
            'nama_divisi'        =>    $nama_divisi,
        ]);
        Session::flash('sukses', 'Nama Divisi Berhasil Di edit');
        return redirect('/divisi');
    }
}
