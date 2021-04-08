<?php

namespace App\Http\Controllers;

use App\Mcp;
use App\Mcp_wsheet_main;
use App\Mcp_wsheet;
use App\Mcp_type;
use App\Mcp_detail;
use Illuminate\Http\Request;

use Input;
use File;
use Session;
use Auth;

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

    public function cetakPdf()
    {
        $data = [
            'foo' => 'bar'
        ];
        $pdf = PDF::loadView('pdf.document', $data);
        return $pdf->stream('document.pdf');
    }

    public function create()
    {
        $no = Mcp::max('number');
        $number_set = ((int)substr($no, 7));
        $number_set += 1;

        $year = date('y');
        $nomor = "MCP/" . $year . "/";
        $number_set = $nomor . sprintf("%05s", $number_set);

        $id                     = Input::get('id');
        $number                 = $number_set;
        $order_name             = strtoupper(Input::get('order_name'));
        $fabricconst            = strtoupper(Input::get('fabricconst'));
        $fabriccomp             = strtoupper(Input::get('fabriccomp'));

        if (Input::get('fabric_desc') == '') {
            $fabric_desc        = '-';
        } else {
            $fabric_desc        = strtoupper(Input::get('fabric_desc'));
        }
        $style                  = strtoupper(Input::get('style'));
        if (Input::get('style_desc') == '') {
            $style_desc         = '-';
        } else {
            $style_desc         = strtoupper(Input::get('style_desc'));
        }
        $delivery_date          = Input::get('delivery_date');
        $revision_count         = 0;
        if (Input::get('revisi_remark') == '') {
            $revisi_remark      = '-';
        } else {
            $revisi_remark      = strtoupper(Input::get('revisi_remark'));
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
                'confirmed_by'      =>  Auth::user()->name
            ]);
            Session::flash('sukses', 'Data MCP Berhasil Di Konfirmasi');
        } else {
            Mcp::where('id', $id)->update([
                'state'             =>  'UNCONFIRMED',
                'confirmed_by'      =>  Auth::user()->name
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
        $id                     = Input::get('id');
        $number                 = strtoupper(Input::get('number'));
        $order_name             = strtoupper(Input::get('order_name'));
        $fabricconst            = strtoupper(Input::get('fabricconst'));
        $fabriccomp             = strtoupper(Input::get('fabriccomp'));

        if (Input::get('fabric_desc') == '') {
            $fabric_desc        = '-';
        } else {
            $fabric_desc        = strtoupper(Input::get('fabric_desc'));
        }
        $style                  = strtoupper(Input::get('style'));
        if (Input::get('style_desc') == '') {
            $style_desc         = '-';
        } else {
            $style_desc         = strtoupper(Input::get('style_desc'));
        }
        $delivery_date          = Input::get('delivery_date');
        $revision_count         = Input::get('revision_count') + 1;
        if (Input::get('revisi_remark') == '') {
            $revisi_remark      = '-';
        } else {
            $revisi_remark      = strtoupper(Input::get('revisi_remark'));
        }
        $state                  = strtoupper(Input::get('state'));

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
        Mcp::where('id', $id)->delete();
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcp');
    }

    public function detail($id, Request $request)
    {
        $mcp = Mcp::where('id', $id)->first();
        $mcp_wsheet_m = Mcp_wsheet_main::where('mcp', $mcp['number'])->get();
        $mcp_wsheet = Mcp_wsheet::where('mcp', $mcp['number'])->get();
        $mcp_type = Mcp_type::where('mcp', $mcp['number'])->get();
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

    public function createws()
    {
        $mcp = strtoupper(Input::get('mcp'));
        $no_urut = strtoupper(Input::get('no_urut'));
        $combo = strtoupper(Input::get('color'));
        $total_qty = Input::get('ws_qty_tot');

        Mcp_wsheet_main::create([
            'mcp' => $mcp,
            'no_urut' => $no_urut,
            'combo' => $combo,
            'total_qty' => $total_qty
        ]);
        $id_mcpwsm = Mcp_wsheet_main::orderBy('id', 'desc')->first();

        $c = count(Input::get('input_size'));

        $size_ar = Input::get('input_size');
        $ws_qty_ar = Input::get('input_ws_qty');
        $tolerance_ar = Input::get('input_tolerance');
        $qty_tot_ar = Input::get('input_qty_tot');

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
        $id_mcpwsm = Input::get('id');
        $mcp = strtoupper(Input::get('mcp'));
        $no_urut = Input::get('no_urut');
        $combo = strtoupper(Input::get('color'));
        $total_qty = Input::get('ws_qty_tot');

        Mcp_wsheet_main::where('id', $id_mcpwsm)->update([
            'mcp' => $mcp,
            'no_urut' => $no_urut,
            'combo' => $combo,
            'total_qty' => $total_qty
        ]);

        $size_ar = Input::get('input_size');
        $ws_qty_ar = Input::get('input_ws_qty');
        $tolerance_ar = Input::get('input_tolerance');
        $qty_tot_ar = Input::get('input_qty_tot');

        $c = count(Input::get('input_size'));

        for ($i = 0; $i < $c; $i++) {
            Mcp_wsheet::where('mcp_wsheet_m', $id_mcpwsm)->update([
                'mcp'           =>  strtoupper($mcp),
                'mcp_wsheet_m'  =>  $id_mcpwsm,
                'no_urut'       =>  $no_urut,
                'combo'         =>  $combo,
                'size'          =>  strtoupper($size_ar[$i]),
                'ws_qty'        =>  $ws_qty_ar[$i],
                'tolerance'     =>  $tolerance_ar[$i],
                'qty_tot'       =>  $qty_tot_ar[$i]
            ]);
        }

        $id_mcp = Mcp::where('number', $mcp)->first();
        // Session::flash('sukses', 'Data Worksheet Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function createtype()
    {
        $mcp = Input::get('mcp');
        $id_wsheet = Input::get('id_wsheet');
        $no_urut = Input::get('no_urut');
        $type = strtoupper(Input::get('type'));
        $fabricconst = strtoupper(Input::get('fabricconst'));
        $fabriccomp = strtoupper(Input::get('fabriccomp'));
        if (Input::get('fabric_desc') == '') {
            $fabric_desc = '-';
        } else {
            $fabric_desc = strtoupper(Input::get('fabric_desc'));
        }
        $component = strtoupper(Input::get('component'));
        $warna = strtoupper(Input::get('color_form'));
        if (Input::get('tujuan') == '') {
            $tujuan = '-';
        } else {
            $tujuan = strtoupper(Input::get('tujuan'));
        }
        if (Input::get('remark') == '') {
            $remark = '-';
        } else {
            $remark = strtoupper(Input::get('remark'));
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
        $id_mcpt = Input::get('id');
        $mcp = strtoupper(Input::get('mcp'));
        $id_wsheet = strtoupper(Input::get('id_wsheet'));
        $no_urut = Input::get('no_urut');
        $type = strtoupper(Input::get('type'));
        $fabricconst = strtoupper(Input::get('fabricconst'));
        $fabriccomp = strtoupper(Input::get('fabriccomp'));
        $fabricdesc = strtoupper(Input::get('fabric_desc'));
        $component = strtoupper(Input::get('component'));
        $warna = strtoupper(Input::get('color'));
        $tujuan = strtoupper(Input::get('tujuan'));
        $remark = strtoupper(Input::get('remark'));
        $created_by = strtoupper(Input::get('created_by'));
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

    public function createdetail(Request $request)
    {
        $mcp = strtoupper(Input::get('mcp'));
        $id_type = Input::get('id_type');
        $urutan = Input::get('urutan');
        $code = strtoupper(Input::get('code'));
        $marker_date = Input::get('marker_date');
        $efisiensi = Input::get('efisiensi');
        $perimeter = Input::get('perimeter');
        $designer = strtoupper(Input::get('designer'));
        $tole_pjg_m = Input::get('tole_pjg_m');
        $tole_lbr_m = Input::get('tole_lbr_m');
        $kons_sz_tgh = Input::get('kons_sz_tgh');
        $tgl_sz_tgh = Input::get('tgl_sz_tgh');
        $panjang_m = Input::get('panjang_m');
        $lebar_m = Input::get('lebar_m');
        $gramasi = Input::get('gramasi');
        $total_skala = Input::get('total_skala');
        $jml_marker = Input::get('jml_marker');
        $jml_ampar = Input::get('jml_ampar');
        $pdf_marker = '-';
        $komponen = strtoupper(Input::get('komponen'));
        $revisi = Input::get('revisi');
        $revisi_remark = strtoupper(Input::get('revisi_remark'));

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
            'pdf_marker' => $pdf_marker,
            'komponen' => $komponen,
            'revisi' => $revisi,
            'revisi_remark' => $revisi_remark
        ]);

        $id_mcp = Mcp::where('number', $mcp)->first();
        // Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function showdetail($id_mcpd, $id_mcp, $qty_d, $size_d)
    {
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
        $mcp = $id_mcp;
        return view('marker.mcpd_show')->with(compact('mcpd'))->with(compact('mcp'))->with(compact('qty_d'))->with(compact('size_d'));
    }

    public function editmcpd($id_mcpd, $id_mcp, $qty_d, $size_d)
    {
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();
        $mcp = $id_mcp;
        return view('marker.mcpd_edit')->with(compact('mcpd'))->with(compact('mcp'))->with(compact('qty_d'))->with(compact('size_d'));
    }


    public function updatemcpd()
    {
        $id = Input::get('id');
        $mcp = strtoupper(Input::get('mcp'));
        $id_type = Input::get('id_type');
        $urutan = Input::get('urutan');
        $code = strtoupper(Input::get('code'));
        $marker_date = Input::get('marker_date');
        $efisiensi = Input::get('efisiensi');
        $perimeter = Input::get('perimeter');
        $designer = strtoupper(Input::get('designer'));
        $tole_pjg_m = Input::get('tole_pjg_m');
        $tole_lbr_m = Input::get('tole_lbr_m');
        $kons_sz_tgh = Input::get('kons_sz_tgh');
        $tgl_sz_tgh = Input::get('tgl_sz_tgh');
        $panjang_m = Input::get('panjang_m');
        $lebar_m = Input::get('lebar_m');
        $gramasi = Input::get('gramasi');
        $total_skala = Input::get('total_skala');
        $jml_marker = Input::get('jml_marker');
        $jml_ampar = Input::get('jml_ampar');
        $pdf_marker = Input::get('pdf_marker');
        if ($pdf_marker == '') {
            $pdf_marker = '-';
        }
        $komponen = strtoupper(Input::get('komponen'));
        $revisi = Input::get('revisi');
        $revisi_remark = strtoupper(Input::get('revisi_remark'));

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
            'pdf_marker' => $pdf_marker,
            'komponen' => $komponen,
            'revisi' => $revisi,
            'revisi_remark' => $revisi_remark
        ]);

        $id_mcp = Mcp::where('number', $mcp)->first();
        // Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mcp/detail/' . $id_mcp->id);
    }

    public function print_rekkons($id_mcp)
    {
        $mcp = Mcp::where('id', $id_mcp)->first();
        $number = $mcp['number'];

        $mcpwsm = Mcp_wsheet_main::where('mcp', $number)->get();
        $mcpws = Mcp_wsheet::where('mcp', $number)->get();
        $mcpt = Mcp_type::where('mcp', $number)->get();
        $mcpd = Mcp_detail::where('mcp', $number)->get();

        // echo 'mcp';
        // echo '<br>';
        // print_r($mcp);
        // echo '<br>';
        // echo '<br>';

        // echo 'mcpwsm';
        // echo '<br>';
        // print_r($mcpwsm);
        // echo '<br>';
        // echo '<br>';

        // echo 'mcpws';
        // echo '<br>';
        // print_r($mcpws);
        // echo '<br>';
        // echo '<br>';

        // echo 'mcpt';
        // echo '<br>';
        // print_r($mcpt);
        // echo '<br>';
        // echo '<br>';

        // echo 'mcpd';
        // echo '<br>';
        // print_r($mcpd);
        // echo '<br>';

        return view('marker.print_rekkons')->with(compact('mcp'))->with(compact('mcpwsm'))->with(compact('mcpws'))->with(compact('mcpws'))->with(compact('mcpt'))->with(compact('mcpd'));
    }

    public function print_ws($id_mcp, $id_mcpwsm, $id_mcpt, $id_mcpd)
    {
        $mcp = Mcp::where('id', $id_mcp)->first();
        $mcpwsm = Mcp_wsheet_main::where('id', $id_mcpwsm)->first();
        $mcpws = Mcp_wsheet::where('mcp_wsheet_m', $id_mcpwsm)->get();
        $mcpt = Mcp_type::where('id', $id_mcpt)->first();
        $mcpd = Mcp_detail::where('id', $id_mcpd)->first();

        return view('marker.print_ws')->with(compact('mcp'))->with(compact('mcpwsm'))->with(compact('mcpws'))->with(compact('mcpws'))->with(compact('mcpt'))->with(compact('mcpd'));
    }
}
