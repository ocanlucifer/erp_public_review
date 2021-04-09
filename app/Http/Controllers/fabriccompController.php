<?php

namespace App\Http\Controllers;

use App\Fabriccomp;
use App\Fabricconst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Requests;
use File;
use Session;
use Auth;

class fabriccompController extends Controller
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
        // $result = Fabriccomp::all();

        $result = Fabriccomp::orderBy('id', 'asc')
            ->paginate(10);
        $fabricconst = Fabricconst::all();

        if ($request->ajax()) {
            $result = Fabriccomp::where('id', 'like', '%' . strtoupper($request->id) . '%')
                ->where('name', 'like', '%' . $request->name . '%')
                ->where('type_name', 'like', '%' . $request->type_name . '%')
                ->where('state', 'like', '%' . $request->state . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('fabriccomp.list', array('result' => $result))->render());
            }
        }

        return view('fabriccomp.index', ['result' => $result])->with(compact('fabricconst'));
    }

    public function new()
    {
        $id             = Requests::input('id');
        $name           = Requests::input('name');
        $fabricconstruct_id  = Requests::input('fabricconstruct_id');
        $type_name      = Requests::input('type_name');
        $state          = 'pending';
        Fabriccomp::create([
            'id'                      =>    strtoupper($id),
            'name'                    =>    $name,
            'fabricconstruct_id'          =>  $fabricconstruct_id,
            'type_name'               => $type_name,
            'state'                   => $state
        ]);

        Session::flash('sukses', 'Data Kompos Kain Berhasil Di simpan');
        return redirect('/fabric_comp');
    }

    public function update()
    {
        $id                  = Requests::input('id');
        $name                = Requests::input('name');
        $fabricconstruct_id       = Requests::input('fabricconstruct_id');
        $type_name               = Requests::input('type_name');
        $state               = Requests::input('state');
        Fabriccomp::where('id', $id)->update([
            'name'              =>  $name,
            'fabricconstruct_id'    =>  $fabricconstruct_id,
            'type_name'         =>  $type_name,
            'state'             =>  $state,
        ]);
        Session::flash('sukses', 'Data Kompos Kain Berhasil Di edit');
        return redirect('/fabric_comp');
    }

    public function delete($id)
    {
        Fabriccomp::where('id', $id)->delete();
        Session::flash('sukses', 'Data fabric compost berhasil dihapus');
        return redirect('/fabric_comp');
    }
}
