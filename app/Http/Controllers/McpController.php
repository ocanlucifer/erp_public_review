<?php

namespace App\Http\Controllers;

use App\Mcp;
use App\Mcp_wsheet_main;
use App\Mcp_wsheet;
use App\Mcp_type;
use App\Mcp_detail;
use App\Mcp_assort;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;
use PDFDOM;
use PDFniklas;

class McpController extends Controller
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
        $result = Mcp::orderby('number', 'DESC')->paginate(10);

        if ($request->ajax()) {
            $result = Mcp::where('number', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('order_name', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('style', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orderBy('number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('marker.mcp_list', array('result' => $result))->render());
            }
        }

        return view('marker.mcp_index', ['result' => $result]);
    }

    public function create()
    {
        $no = Mcp::max('number');
        $number_set = ((int)substr($no, 7));
        $number_set += 1;

        $year = date('y');
        $nomor = "MCP/" . $year . "/";
        $number_set = $nomor . sprintf("%05s", $number_set);

        $id                     = Requests::input('id');
        $number                 = $number_set;
        $order_name             = strtoupper(Requests::input('order_name'));
        $fabricconst            = strtoupper(Requests::input('fabricconst'));
        $fabriccomp             = strtoupper(Requests::input('fabriccomp'));

        if (Requests::input('fabric_desc') == '') {
            $fabric_desc        = '-';
        } else {
            $fabric_desc        = strtoupper(Requests::input('fabric_desc'));
        }
        $style                  = strtoupper(Requests::input('style'));
        if (Requests::input('style_desc') == '') {
            $style_desc         = '-';
        } else {
            $style_desc         = strtoupper(Requests::input('style_desc'));
        }
        $delivery_date          = Requests::input('delivery_date');
        $revision_count         = 0;
        if (Requests::input('revisi_remark') == '') {
            $revisi_remark      = '-';
        } else {
            $revisi_remark      = strtoupper(Requests::input('revisi_remark'));
        }
        $state                  = strtoupper('pending');
        $created_by             = Auth::user()->name;
        $updated_by             = '-';
        $confirmed_by           = '-';

        Mcp::create([
            'number'            =>  $number,
            'order_name'        =>  $order_name,
            'fabric_const'      =>  $fabricconst,
            'fabric_comp'       =>  $fabriccomp,
            'fabric_desc'       =>  $fabric_desc,
            'style'             =>  $style,
            'style_desc'        =>  $style_desc,
            'delivery_date'     =>  $delivery_date,
            'revision_count'    =>  $revision_count,
            'revisi_remark'     =>  $revisi_remark,
            'state'             =>  $state,
            'created_by'        =>  $created_by,
            'updated_by'        =>  $updated_by,
            'confirmed_by'      =>  $confirmed_by
        ]);

        Session::flash('sukses', 'Data MCP Berhasil Di simpan');
        return redirect('/mcp');
    }

    public function confirm($id, $state)
    {
        if ($state == "1") {
            Mcp::where('id', $id)->update([
                'state'             =>  'CONFIRMED',
                'confirmed_by'      =>  strtoupper(Auth::user()->name)
            ]);
            Session::flash('sukses', 'Data MCP Berhasil Di Konfirmasi');
        } else {
            Mcp::where('id', $id)->update([
                'state'             =>  'UNCONFIRMED',
                'confirmed_by'      =>  strtoupper(Auth::user()->name)
            ]);
            Session::flash('sukses', 'Data MCP Berhasil Di Konfirmasi');
        }
        return redirect('/mcp/detail/' . $id);
    }

    public function edit($id)
    {
        $result = Mcp::where('id', $id)->first();

        return view('marker.mcp_edit')->with(compact('result'));
    }

    public function update()
    {
        $id                     = Requests::input('id');
        $number                 = strtoupper(Requests::input('number'));
        $order_name             = strtoupper(Requests::input('order_name'));
        $fabricconst            = strtoupper(Requests::input('fabricconst'));
        $fabriccomp             = strtoupper(Requests::input('fabriccomp'));

        if (Requests::input('fabric_desc') == '') {
            $fabric_desc        = '-';
        } else {
            $fabric_desc        = strtoupper(Requests::input('fabric_desc'));
        }
        $style                  = strtoupper(Requests::input('style'));
        if (Requests::input('style_desc') == '') {
            $style_desc         = '-';
        } else {
            $style_desc         = strtoupper(Requests::input('style_desc'));
        }
        $delivery_date          = Requests::input('delivery_date');
        $revision_count         = Requests::input('revision_count') + 1;
        if (Requests::input('revisi_remark') == '') {
            $revisi_remark      = '-';
        } else {
            $revisi_remark      = strtoupper(Requests::input('revisi_remark'));
        }
        $state                  = strtoupper(Requests::input('state'));

        Mcp::where('id', $id)->update([
            'number'            =>  $number,
            'order_name'        =>  $order_name,
            'fabric_const'      =>  $fabricconst,
            'fabric_comp'       =>  $fabriccomp,
            'fabric_desc'       =>  $fabric_desc,
            'style'             =>  $style,
            'style_desc'        =>  $style_desc,
            'delivery_date'     =>  $delivery_date,
            'revision_count'    =>  $revision_count,
            'revisi_remark'     =>  $revisi_remark,
            'state'             =>  $state,
            'updated_by'        =>  Auth::user()->name
        ]);

        Session::flash('sukses', 'Data MCP Berhasil Di update');
        return redirect('/mcp/detail/' . $id);
    }

    public function delete($id)
    {
        $mcp = Mcp::where('id', $id)->first();
        $mcpwsm = Mcp_wsheet_main::where('mcp', $mcp['number'])->get();

        foreach ($mcpwsm as $wsm) {
            // $mcpws = Mcp_wsheet::where('mcp_wsheet_m', $wsm['id'])->get();
            $mcpt = Mcp_type::where('id_wsheet', $wsm['id'])->get();

            foreach ($mcpt as $t) {
                $mcpd = Mcp_detail::where('id_type', $t['id'])->get();
                foreach ($mcpd as $d) {
                    Mcp_assort::where('id_mcpd', $d['id'])->delete();
                }
                Mcp_detail::where('id_type', $t['id'])->delete();
            }

            Mcp_wsheet::where('mcp_wsheet_m', $wsm['id'])->delete();
            Mcp_type::where('id_wsheet', $wsm['id'])->delete();
        }

        Mcp_wsheet_main::where('mcp', $mcp['number'])->delete();
        Mcp::where('id', $id)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcp');
    }

    public function detail($id, Request $request)
    {
        $mcp = Mcp::where('id', $id)->first();
        $mcp_wsheet_m = Mcp_wsheet_main::where('mcp', $mcp['number'])->get();
        $mcp_wsheet = Mcp_wsheet::where('mcp', $mcp['number'])->get();
        $mcp_type = Mcp_type::where('mcp', $mcp['number'])->orderBy('no_urut', 'asc')->get();
        $mcp_detail = Mcp_detail::where('mcp', $mcp['number'])->get();

        // if ($request->ajax()) {
        //     $result = Mcp::where('number', 'like', '%' . strtoupper($request->keyword) . '%')
        //         ->orWhere('order_name', 'like', '%' . $request->keyword . '%')
        //         ->orderBy('number', 'DESC')
        //         ->paginate(10);

        //     $result->appends($request->all());
        //     if ($result) {
        //         return \Response::json(\View::make('marker.mcp_list', array('result' => $result))->render());
        //     }
        // }

        return view('marker.mcpd_index')->with(compact('mcp'))->with(compact('mcp_wsheet'))->with(compact('mcp_wsheet_m'))->with(compact('mcp_type'))->with(compact('mcp_detail'));
    }

    public function detail_getsize(Request $request)
    {
        $id_mcpwsm = $request->get('mcpwsmid');
        $hasil = Mcp_wsheet::select('size', 'qty_tot')->where('mcp_wsheet_m', $id_mcpwsm)->get();
        return response()->json($hasil);
    }

    public function edit_getsize(Request $request)
    {
        $id_mcpd = $request->get('mcpd_id');
        $hasil = Mcp_assort::select('id', 'size', 'qty_ws', 'scale')->where('id_mcpd', $id_mcpd)->get();
        return response()->json($hasil);
    }

    public function createws()
    {
        $mcp = strtoupper(Requests::input('mcp'));
        $no_urut = strtoupper(Requests::input('no_urut'));
        $combo = strtoupper(Requests::input('color'));
        $total_qty = Requests::input('ws_qty_tot');

        Mcp_wsheet_main::create([
            'mcp' => $mcp,
            'no_urut' => $no_urut,
            'combo' => $combo,
            'total_qty' => $total_qty
        ]);
        $id_mcpwsm = Mcp_wsheet_main::orderBy('id', 'desc')->first();

        $c = count(Requests::input('input_size'));

        $size_ar = Requests::input('input_size');
        $ws_qty_ar = Requests::input('input_ws_qty');
        $tolerance_ar = Requests::input('input_tolerance');
        $qty_tot_ar = Requests::input('input_qty_tot');

        for ($i = 0; $i < $c; ++$i) {
            Mcp_wsheet::create([
                'mcp'           => $mcp,
                'mcp_wsheet_m'  => $id_mcpwsm['id'],
                'no_urut'       =>  $no_urut,
                'combo'         =>  $combo,
                'size'          =>  strtoupper($size_ar[$i]),
                'ws_qty'        =>  $ws_qty_ar[$i],
                'tolerance'     =>  $tolerance_ar[$i],
                'qty_tot'       =>  $qty_tot_ar[$i]
            ]);
        }

        $id_mcp = Mcp::where('number', $mcp)->first();
        Mcp::where('id', $mcp)->update([
            'updated_by'    => Auth::user()->name
        ]);

        // Session::flash('sukses', 'Data Worksheet Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function editws($id_mcpwsm, $id_mcp)
    {
        $mcpwsm = Mcp_wsheet_main::where('id', $id_mcpwsm)->first();
        $mcpws = Mcp_wsheet::where('mcp_wsheet_m', $id_mcpwsm)->get();
        $mcp = $id_mcp;
        return view('marker.mcpws_edit')->with(compact('mcpwsm'))->with(compact('mcpws'))->with(compact('mcp'));
    }

    public function updatews()
    {
        $id_mcpwsm = Requests::input('id');
        $mcp = strtoupper(Requests::input('mcp'));
        $no_urut = Requests::input('no_urut');
        $combo = strtoupper(Requests::input('color'));
        $total_qty = Requests::input('ws_qty_tot');

        $size_ar = Requests::input('input_size');
        $ws_qty_ar = Requests::input('input_ws_qty');
        $tolerance_ar = Requests::input('input_tolerance');
        $qty_tot_ar = Requests::input('input_qty_tot');

        // Update Wsheet
        $c = count(Requests::input('input_size'));

        Mcp_wsheet::where('mcp_wsheet_m', $id_mcpwsm)->delete();
        for ($i = 0; $i < $c; $i++) {
            Mcp_wsheet::create([
                'mcp'           => $mcp,
                'mcp_wsheet_m'  => $id_mcpwsm,
                'no_urut'       =>  $no_urut,
                'combo'         =>  $combo,
                'size'          =>  strtoupper($size_ar[$i]),
                'ws_qty'        =>  $ws_qty_ar[$i],
                'tolerance'     =>  $tolerance_ar[$i],
                'qty_tot'       =>  $qty_tot_ar[$i]
            ]);
        }

        // Update Assort
        $mcpt = Mcp_type::where('id_wsheet', $id_mcpwsm)->first();
        $mcpd = Mcp_detail::where('id_type', $mcpt['id'])->get();
        foreach ($mcpd as $d) {
            Mcp_assort::where('id_mcpd', $d['id'])->delete();

            for ($i = 0; $i < $c; $i++) {
                Mcp_assort::create([
                    'id_mcpd'   => $d['id'],
                    'size'      => strtoupper($size_ar[$i]),
                    'qty_ws'    => $ws_qty_ar[$i],
                    'scale'     => 0
                ]);
            }
        }



        $id_mcp = Mcp::where('number', $mcp)->first();
        Session::flash('sukses', 'Data Worksheet Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function deletews($id)
    {
        $mcpwsm = Mcp_wsheet_main::where('id', $id)->first();
        $mcp = Mcp::where('number', $mcpwsm->mcp)->first();
        $mcpt = Mcp_type::where('id_wsheet', $id)->get();

        foreach ($mcpt as $type) {
            $mcpd = Mcp_detail::where('id_type', $type['id'])->get();
            foreach ($mcpd as $d) {
                Mcp_assort::where('id_mcpd', $d['id'])->delete();
            }
            Mcp_detail::where('id_type', $type['id'])->delete();
        }
        Mcp_type::where('id_wsheet', $id)->delete();
        Mcp_wsheet::where('mcp_wsheet_m', $id)->delete();
        Mcp_wsheet_main::where('id', $id)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcp/detail/' . $mcp->id);
    }

    public function createtype()
    {
        $mcp = Requests::input('mcp');
        $id_wsheet = Requests::input('id_wsheet');
        $no_urut = Requests::input('no_urut');
        $type = strtoupper(Requests::input('type'));
        $fabricconst = strtoupper(Requests::input('fabricconst'));
        $fabriccomp = strtoupper(Requests::input('fabriccomp'));
        if (Requests::input('fabric_desc') == '') {
            $fabric_desc = '-';
        } else {
            $fabric_desc = strtoupper(Requests::input('fabric_desc'));
        }
        $component = strtoupper(Requests::input('component'));
        $warna = strtoupper(Requests::input('color_form'));
        if (Requests::input('tujuan') == '') {
            $tujuan = '-';
        } else {
            $tujuan = strtoupper(Requests::input('tujuan'));
        }
        if (Requests::input('remark') == '') {
            $remark = '-';
        } else {
            $remark = strtoupper(Requests::input('remark'));
        }
        $created_by = Auth::user()->name;
        $updated_by = '-';

        Mcp_type::create([
            'mcp'           => $mcp,
            'id_wsheet'           => $id_wsheet,
            'no_urut'           => $no_urut,
            'type'           => $type,
            'fabricconst'           => $fabricconst,
            'fabriccomp'           => $fabriccomp,
            'fabricdesc'           => $fabric_desc,
            'component'           => $component,
            'warna'           => $warna,
            'tujuan'           => $tujuan,
            'remark'           => $remark,
            'created_by'           => $created_by,
            'updated_by'           => $updated_by
        ]);

        $id_mcp = Mcp::where('number', $mcp)->first();
        // Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function editmcpt($id_mcpt, $id_mcp)
    {
        $mcpt = Mcp_type::where('id', $id_mcpt)->first();
        $mcp = $id_mcp;
        return view('marker.mcpt_edit')->with(compact('mcpt'))->with(compact('mcp'));
    }

    public function updatemcpt()
    {
        $id_mcpt = Requests::input('id');
        $mcp = strtoupper(Requests::input('mcp'));
        $id_wsheet = strtoupper(Requests::input('id_wsheet'));
        $no_urut = Requests::input('no_urut');
        $type = strtoupper(Requests::input('type'));
        $fabricconst = strtoupper(Requests::input('fabric_construct'));
        $fabriccomp = strtoupper(Requests::input('fabric_compost'));
        $fabricdesc = strtoupper(Requests::input('fabric_desc'));
        $component = strtoupper(Requests::input('component'));
        $warna = strtoupper(Requests::input('color'));
        $tujuan = strtoupper(Requests::input('tujuan'));
        $remark = strtoupper(Requests::input('remark'));
        $created_by = strtoupper(Requests::input('created_by'));
        $updated_by = strtoupper(Auth::user()->name);

        Mcp_type::where('id', $id_mcpt)->update([
            'mcp' => $mcp,
            'id_wsheet' => $id_wsheet,
            'no_urut' => $no_urut,
            'type' => $type,
            'fabricconst' => $fabricconst,
            'fabriccomp' => $fabriccomp,
            'fabricdesc' => $fabricdesc,
            'component' => $component,
            'warna' => $warna,
            'tujuan' => $tujuan,
            'remark' => $remark,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        $id_mcp = Mcp::where('number', $mcp)->first();
        // Session::flash('sukses', 'Data Worksheet Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function deletemcpt($id)
    {
        $mcpt = Mcp_type::where('id', $id)->first();
        $id_mcp = Mcp::where('number', $mcpt->mcp)->first();
        $mcpd = Mcp_detail::where('id_type', $id)->get();
        foreach ($mcpd as $d) {
            Mcp_assort::where('id_mcpd', $d['id'])->delete();
        }

        Mcp_detail::where('id_type', $id)->delete();
        Mcp_type::where('id', $id)->delete();
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function createdetail(Request $request)
    {

        // === input for detail===
        $mcp = strtoupper(Requests::input('mcp'));
        $id_type = Requests::input('id_type');
        $urutan = Requests::input('urutan');
        $code = strtoupper(Requests::input('code'));
        $marker_date = Requests::input('marker_date');
        $efisiensi = Requests::input('efisiensi');
        $perimeter = Requests::input('perimeter');
        $designer = strtoupper(Requests::input('designer'));
        $tole_pjg_m = Requests::input('tole_pjg_m');
        $tole_lbr_m = Requests::input('tole_lbr_m');
        $kons_sz_tgh = Requests::input('kons_sz_tgh');
        $tgl_sz_tgh = Requests::input('tgl_sz_tgh');
        $panjang_m = Requests::input('panjang_m');
        $lebar_m = Requests::input('lebar_m');
        $gramasi = Requests::input('gramasi');
        $total_skala = Requests::input('total_skala');
        $jml_marker = Requests::input('jml_marker');
        $jml_ampar = Requests::input('jml_ampar');

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $nama_file =  time() . "_" . $file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = "-";
        }
        // END of upload pdf

        $komponen = strtoupper(Requests::input('komponen'));
        $revisi = Requests::input('revisi');
        $revisi_remark = strtoupper(Requests::input('revisi_remark'));

        Mcp_detail::create([
            'mcp' => $mcp,
            'id_type' => $id_type,
            'urutan' => $urutan,
            'code' => $code,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
            'designer' => $designer,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'kons_sz_tgh' => $kons_sz_tgh,
            'tgl_sz_tgh' => $tgl_sz_tgh,
            'panjang_m' => $panjang_m,
            'lebar_m' => $lebar_m,
            'gramasi' => $gramasi,
            'total_skala' => $total_skala,
            'jml_marker' => $jml_marker,
            'jml_ampar' => $jml_ampar,
            'pdf_marker' => $nama_file,
            'komponen' => $komponen,
            'revisi' => $revisi,
            'revisi_remark' => $revisi_remark
        ]);

        // === input for assortment ===
        $c = count(Requests::input('input_det_size'));
        $as_mcpd = Mcp_detail::where('mcp', $mcp)->first();

        $as_size = Requests::input('input_det_size');
        $as_qty = Requests::input('input_det_qty');
        $as_scale = Requests::input('input_det_scale');

        for ($i = 0; $i < $c; $i++) {
            Mcp_assort::create([
                "id_mcpd" => $as_mcpd['id'],
                "size" => strtoupper($as_size[$i]),
                "qty_ws" => $as_qty[$i],
                "scale" => $as_scale[$i]
            ]);
        }

        $id_mcp = Mcp::where('number', $mcp)->first();
        Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function showdetail($id_mcpd, $id_mcp, $id_mcpwsm)
    {
        $mcpwsm_id = $id_mcpwsm;
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
        $mcpa = Mcp_assort::where('id_mcpd', $id_mcpd)->orderBy('id', 'DESC')->get();
        $mcp = $id_mcp;
        return view('marker.mcpd_show')->with(compact('mcpwsm_id'))->with(compact('mcpd'))->with(compact('mcp'))->with(compact('mcpa'));
        // return view('marker.mcpd_show')->with(compact('mcpd'))->with(compact('mcp'))->with(compact('qty_d'))->with(compact('size_d'));
    }

    public function editmcpd($id_mcpd, $id_mcp, $id_mcpwsm)
    {
        $mcpwsm_id = $id_mcpwsm;
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
        $mcpa = Mcp_assort::where('id_mcpd', $id_mcpd)->orderBy('id', 'DESC')->get();
        $mcp = $id_mcp;
        return view('marker.mcpd_edit')->with(compact('mcpwsm_id'))->with(compact('mcpd'))->with(compact('mcp'))->with(compact('mcpa'));
    }

    // public function editmcpd($id_mcpd, $id_mcp, $qty_d, $size_d)
    // {
    //     $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
    //     $mcpa = Mcp_assort::where('id_mcpd', $id_mcpd)->orderBy('id', 'DESC')->get();
    //     $mcp = $id_mcp;
    //     return view('marker.mcpd_edit_new')->with(compact('mcpd'))->with(compact('mcp'))->with(compact('qty_d'))->with(compact('size_d'))->with(compact('mcpa'));
    // }


    public function updatemcpd(Request $request)
    {
        $id = Requests::input('id');

        // update assortment
        $c = count(Requests::input('input_det_size'));

        $id_mcpa = Requests::input('input_id_mcpa');
        $as_qty = Requests::input('input_det_qty');
        $as_scale = Requests::input('input_det_scale');

        for ($i = 0; $i < $c; $i++) {
            Mcp_assort::where('id', $id_mcpa[$i])->update([
                "qty_ws" => $as_qty[$i],
                "scale" => $as_scale[$i]
            ]);
        }

        // preparation update detail
        $mcp = strtoupper(Requests::input('mcp'));
        $id_type = Requests::input('id_type');
        $urutan = Requests::input('urutan');
        $code = strtoupper(Requests::input('code'));
        $marker_date = Requests::input('marker_date');
        $efisiensi = Requests::input('efisiensi');
        $perimeter = Requests::input('perimeter');
        $designer = strtoupper(Requests::input('designer'));
        $tole_pjg_m = Requests::input('tole_pjg_m');
        $tole_lbr_m = Requests::input('tole_lbr_m');
        $kons_sz_tgh = Requests::input('kons_sz_tgh');
        $tgl_sz_tgh = Requests::input('tgl_sz_tgh');
        $panjang_m = Requests::input('panjang_m');
        $lebar_m = Requests::input('lebar_m');
        $gramasi = Requests::input('gramasi');
        $total_skala = Requests::input('total_skala');
        $jml_marker = Requests::input('jml_marker');
        $jml_ampar = Requests::input('jml_ampar');
        $nama_file = Requests::input('pdf_marker_name');

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $nama_file =  time() . "_" . $file->getClientOriginalName();
            // hapus file
            $old_file = Mcp_detail::where('id', $id)->first();
            File::delete('mcp_files/' . $old_file->pdf_marker);
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        }
        // END of upload pdf

        $komponen = strtoupper(Requests::input('komponen'));
        $revisi = Requests::input('revisi');
        $revisi_remark = strtoupper(Requests::input('revisi_remark'));

        Mcp_detail::where('id', $id)->update([
            'mcp' => $mcp,
            'id_type' => $id_type,
            'urutan' => $urutan,
            'code' => $code,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
            'designer' => $designer,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'kons_sz_tgh' => $kons_sz_tgh,
            'tgl_sz_tgh' => $tgl_sz_tgh,
            'panjang_m' => $panjang_m,
            'lebar_m' => $lebar_m,
            'gramasi' => $gramasi,
            'total_skala' => $total_skala,
            'jml_marker' => $jml_marker,
            'jml_ampar' => $jml_ampar,
            'pdf_marker' => $nama_file,
            'komponen' => $komponen,
            'revisi' => $revisi,
            'revisi_remark' => $revisi_remark
        ]);

        $id_mcp = Mcp::where('number', $mcp)->first();
        Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function deletemcpd($id)
    {
        $mcpd = Mcp_detail::where('id', $id)->first();
        $id_mcp = Mcp::where('number', $mcpd->mcp)->first();

        Mcp_assort::where('id_mcpd', $id)->delete();
        Mcp_detail::where('id', $id)->delete();
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    // public function print_rekkonsdom($id_mcp)
    // {
    //     $mcp = Mcp::where('id', $id_mcp)->first();
    //     $number = $mcp['number'];

    //     $mcpwsm = Mcp_wsheet_main::where('mcp', $number)->get();
    //     $mcpws = Mcp_wsheet::where('mcp', $number)->get();
    //     $mcpt = Mcp_type::where('mcp', $number)->get();
    //     $mcpd = Mcp_detail::where('mcp', $number)->get();

    //     $pdf = PDFDOM::loadview('marker.print_rekkonsdom', [
    //         'mcp' => $mcp,
    //         'mcpwsm' => $mcpwsm,
    //         'mcpws' => $mcpws,
    //         'mcpt' => $mcpt,
    //         'mcpd' => $mcpd
    //     ]);
    //     return $pdf->download('rekap-konsumsi-pdf');
    // }

    public function print_rekkons($id_mcp)
    {


        $mcp = Mcp::where('id', $id_mcp)->first();
        $number = $mcp['number'];

        $mcpwsm = Mcp_wsheet_main::where('mcp', $number)->get();
        $mcpws = Mcp_wsheet::where('mcp', $number)->get();
        $mcpt = Mcp_type::where('mcp', $number)->get();
        $mcpd = Mcp_detail::where('mcp', $number)->get();


        return view('marker.print_rekkons')->with(compact('mcp'))->with(compact('mcpwsm'))->with(compact('mcpws'))->with(compact('mcpws'))->with(compact('mcpt'))->with(compact('mcpd'));
    }

    public function print_ws($id_mcp, $id_mcpwsm, $id_mcpt, $id_mcpd)
    {
        $mcp = Mcp::where('id', $id_mcp)->first();
        $mcpwsm = Mcp_wsheet_main::where('id', $id_mcpwsm)->first();
        $mcpws = Mcp_wsheet::where('mcp_wsheet_m', $id_mcpwsm)->get();
        $mcpt = Mcp_type::where('id', $id_mcpt)->first();
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
        $mcpa = Mcp_assort::where('id_mcpd', $id_mcpd)->get();

        return view('marker.print_ws')->with(compact('mcp'))->with(compact('mcpwsm'))->with(compact('mcpws'))->with(compact('mcpws'))->with(compact('mcpt'))->with(compact('mcpd'))->with(compact('mcpa'));
    }
}
