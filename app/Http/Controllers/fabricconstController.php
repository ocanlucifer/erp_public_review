<?php

namespace App\Http\Controllers;

use App\Fabricconst;
use Illuminate\Http\Request;

use Input;
use File;
use Session;
use Auth;

class fabricconstController extends Controller
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
        $result = Fabricconst::orderBy('id', 'asc')
            ->paginate(10);


        if ($request->ajax()) {
            $result = Fabricconst::where('id', 'like', '%' . strtoupper($request->id) . '%')
                ->where('name', 'like', '%' . $request->name . '%')
                ->where('material_type', 'like', '%' . $request->material_type . '%')
                ->where('state', 'like', '%' . $request->state . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('fabricconst.list', array('result' => $result))->render());
            }
        }

        return view('fabricconst.index', ['result' => $result]);
    }

    public function new()
    {
        $id         = Input::get('id');
        $name = Input::get('name');
        $material_type       = Input::get('material_type');
        $state = 'pending';
        Fabricconst::create([
            'id'            =>    strtoupper($id),
            'name'            =>    $name,
            'material_type'          =>  $material_type,
            'state'         => $state
        ]);

        Session::flash('sukses', 'Data Marker Berhasil Di simpan');
        return redirect('/fabric_const');
    }

    public function update()
    {
        $id                  = Input::get('id');
        $name                = Input::get('name');
        $material_type       = Input::get('material_type');
        $state               = Input::get('state');
        Fabricconst::where('id', $id)->update([
            'name'                =>  $name,
            'material_type'       =>  $material_type,
            'state'               =>  $state,
        ]);
        Session::flash('sukses', 'Data Marker Berhasil Di edit');
        return redirect('/fabric_const');
    }

    public function delete($id)
    {
        Fabricconst::where('id', $id)->delete();
        Session::flash('sukses', 'Data fabric constructor berhasil dihapus');
        return redirect('/fabric_const');
    }
}
