<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MarkerFabric;
use App\Fabricconst;
use App\Fabriccomp;
use App\Marker;
use App\MarkerDesc;
use App\Document;
use Input;
use File;
use Session;
use Auth;

class MarkerfabricController extends Controller
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
        // ambil data marker fabric dengan id marker yang diklik
        $markerfab = MarkerFabric::where('id_marker', $id)->get();

        return view('markerfabric.index', ['markerfab' => $markerfab]);
    }

    public function getData(Request $request, $id)
    {
        $result = MarkerFabric::where('id_marker', $id)
            ->orderBy('id', 'asc')
            ->paginate(10);

        if ($result) {

            $id_marker = $id;
            $idmarkerfab = MarkerFabric::where('id_marker', $id)->first();
            $fabricconst = Fabricconst::all();
            $fabriccomp = Fabriccomp::all();
            $marker = MarkerFabric::all();

            if ($request->ajax()) {
                $result = MarkerFabric::where('id_marker_fabric', $id)
                    ->orderBy('id_marker_fabric', 'asc')
                    ->paginate(10);

                $result->appends($request->all());
                if ($result) {
                    return \Response::json(\View::make('markerfabric.list', array('result' => $result))->render());
                }
            }

            return view('markerfabric.index', ['result' => $result], compact('id_marker'))->with(compact('fabricconst'))->with(compact('fabriccomp'))->with(compact('idmarkerfab'));
        } else {
            $fabricconst = Fabricconst::all();
            $fabriccomp = Fabriccomp::all();

            return view('markerfabric.index', ['result' => $result])->with(compact('fabricconst'))->with(compact('fabriccomp'));
        }
    }

    public function new()
    {
        $id                  = Input::get('id');
        $id_marker           = Input::get('id_marker');
        $id_fabric_construct  = Input::get('id_fabric_construct');
        $id_fabric_compost   = Input::get('id_fabric_compost');
        $name                = Input::get('name');
        $description             = Input::get('description');
        $gramasi             = Input::get('gramasi');
        $unit                = Input::get('unit');
        $marker_type         = Input::get('marker_type');

        MarkerFabric::create([
            'id'                   =>  strtoupper($id),
            'id_marker'            =>  $id_marker,
            'id_fabric_construct'   =>  $id_fabric_construct,
            'id_fabric_compost'    =>  $id_fabric_compost,
            'name'                  =>  $name,
            'description'           =>  $description,
            'gramasi'              =>  $gramasi,
            'unit'                 =>  $unit,
            'marker_type'          =>  $marker_type
        ]);

        Session::flash('sukses', 'Data Marker Fabric Berhasil Di simpan');
        return redirect('/markerfabric/' . $id_marker);
    }

    public function update()
    {
        $id          = Input::get('id');
        $id_marker                  = Input::get('id_marker');
        $id_fabric_construct       = Input::get('id_fabric_construct');
        $id_fabric_compost       = Input::get('id_fabric_compost');
        $description       = Input::get('description');
        $gramasi       = Input::get('gramasi');
        $unit       = Input::get('unit');
        $marker_type       = Input::get('marker_type');

        MarkerFabric::where('id', $id)->update([
            'id_marker'       =>  $id_marker,
            'id_fabric_construct'       =>  $id_fabric_construct,
            'id_fabric_compost'       =>  $id_fabric_compost,
            'description'       =>  $description,
            'gramasi'       =>  $gramasi,
            'unit'       =>  $unit,
            'marker_type'       =>  $marker_type
        ]);
        Session::flash('sukses', 'Data Production Marker Berhasil Di edit');
        return redirect('/markerfabric/' . $id_marker);
    }

    public function getFabricComp(Request $request)
    {
        $id_const = $request->id;
        $fab_comp = Fabriccomp::where('fabricconstruct_id', $id_const)->get();
        return response()->json(['success' => $fab_comp]);
    }

    public function delete($id)
    {
        $data = MarkerFabric::where('id', $id)->first();
        $id_marker = $data['id_marker'];
        MarkerFabric::where('id', $id)->delete();
        Session::flash('sukses', 'Data marker fabric berhasil dihapus');
        return redirect('/markerfabric/' . $id_marker);
    }

    public function print($id)
    {
        $marker = Marker::where('id', $id)->first();
        $markerfab = MarkerFabric::where('id_marker', $id)->get();

        $markerdesc = [];
        foreach ($markerfab as $mfb) {
            $markerdesc[] = markerdesc::where('markerfab_id', $mfb['id'])->get();
        }

        $no_document = $marker['no_document'];
        $document = Document::where('no_document', $no_document)->first();

        // print_r($markerdesc[0][0]['markerfab_id']);
        // echo '<br>';
        // echo '<br>';
        // print_r($markerdesc[0][1]['markerfab_id']);
        // echo '<br>';
        // echo '<br>';
        // print_r($markerdesc[1][0]['markerfab_id']);
        // die;

        return view('markerfabric.print')->with(compact('marker'))->with(compact('markerfab'))->with(compact('markerdesc'))->with(compact('document'));
    }
}
