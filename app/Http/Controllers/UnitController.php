<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Unit;
use Input;
use File;
use Session;
use Auth;

class UnitController extends Controller
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
        $result = Unit::orderBy('code', 'asc')
            ->paginate(10);


        if ($request->ajax()) {
            $result = Unit::where('code', 'like', '%' . strtoupper($request->code) . '%')
                ->where('name', 'like', '%' . strtoupper($request->name) . '%')
                ->where('type', 'like', '%' . strtoupper($request->type) . '%')
                ->orderBy('code', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('unit.list', array('result' => $result))->render());
            }
        }

        return view('unit.index', ['result' => $result]);
    }

    public function editform(Request $request)
    {
        $unit = Unit::where('code', '=', $request->id)->first();
        if ($unit) {
            return \Response::json(\View::make('unit.editform', array('unit' => $unit))->render());
        }
    }

    public function delete($code)
    {
        Unit::where('code', $code)->delete();
        Session::flash('sukses', 'unit berhasil dihapus');
        return redirect('/unit');
    }

    public function new()
    {
        $code         = Input::get('code');
        $name         = Input::get('name');
        $type         = Input::get('type');

        Unit::create([
            'code'            =>    strtoupper($code),
            'name'            =>    strtoupper($name),
            'type'            =>    strtoupper($type),
        ]);

        Session::flash('sukses', 'Data unit Berhasil Di simpan');
        return redirect('/unit');
    }

    public function update()
    {
        $code          = Input::get('code');
        $name          = Input::get('name');
        $type          = Input::get('type');
        Unit::where('code', $code)->update([
            'name'       =>  strtoupper($name),
            'type'       =>  strtoupper($type),
        ]);
        Session::flash('sukses', 'Data unit Berhasil Di edit');
        return redirect('/unit');
    }

    public function getByAjax()
    {
        $result = Unit::all();
        return response()->json($result);
    }
}
