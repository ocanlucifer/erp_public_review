<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mcp;
use App\Mp;
use App\Mp_wsheet_main;
use App\Mp_wsheet;
use App\Mp_type;
use App\Mp_detail;
use App\Mp_assort;
use App\Mp_detail_piping;

use Requests;
use File;
use Session;
use Auth;

class MarkerproController extends Controller
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
        $result = Mp::orderby('number', 'DESC')->paginate(10);

        if ($request->ajax()) {
            $result = Mp::where('number', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('order_name', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('style', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orderBy('number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('marker.mp_list', array('result' => $result))->render());
            }
        }

        return view('marker.mp_index', ['result' => $result]);
    }

    public function detail($id, Request $request)
    {
        $mp = Mp::where('id', $id)->first();
        $mp_wsheet_m = Mp_wsheet_main::where('mp', $mp['number'])->get();
        $mp_wsheet = Mp_wsheet::where('mp', $mp['number'])->get();
        $mp_type = Mp_type::where('mp', $mp['number'])->orderBy('no_urut', 'asc')->get();
        $mp_detail = Mp_detail::where('mp', $mp['number'])->get();
        $mp_detail_pi = Mp_detail_piping::where('mp', $mp['number'])->get();

        return view('marker.mpd_index')->with(compact('mp'))->with(compact('mp_wsheet'))->with(compact('mp_wsheet_m'))->with(compact('mp_type'))->with(compact('mp_detail'))->with(compact('mp_detail_pi'));
    }

    public function edit($id)
    {
        $result = Mp::where('id', $id)->first();
        return view('marker.mp_edit')->with(compact('result'));
    }

    public function update()
    {
        $id                     = Requests::input('id');
        $order_name             = strtoupper(Requests::input('order_name'));

        Mp::where('id', $id)->update([
            'order_name'        =>  $order_name,
            'updated_by'        =>  Auth::user()->name
        ]);

        Session::flash('sukses', 'Data Production Marker Berhasil Di update');
        return redirect('/mp/detail/' . $id);
    }

    public function createtype()
    {
        $mp = Requests::input('mp');
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
        $created_by = strtoupper(Auth::user()->name);
        $updated_by = '-';

        Mp_type::create([
            'mp'           => $mp,
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

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function deletews($id)
    {
        $mpwsm = Mp_wsheet_main::where('id', $id)->first();
        $mp = Mp::where('number', $mpwsm->mp)->first();
        $mpt = Mp_type::where('id_wsheet', $id)->get();

        foreach ($mpt as $type) {
            $mpd = Mp_detail::where('id_type', $type['id'])->get();
            foreach ($mpd as $d) {
                Mp_assort::where('id_mpd', $d['id'])->delete();
            }
            Mp_detail::where('id_type', $type['id'])->delete();
        }
        Mp_type::where('id_wsheet', $id)->delete();
        Mp_wsheet::where('mp_wsheet_m', $id)->delete();
        Mp_wsheet_main::where('id', $id)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mp/detail/' . $mp->id);
    }

    public function editws($id_mpwsm, $id_mp)
    {
        $mpwsm = Mp_wsheet_main::where('id', $id_mpwsm)->first();
        $mpws = Mp_wsheet::where('mp_wsheet_m', $id_mpwsm)->get();
        $mp = $id_mp;
        return view('marker.mpws_edit')->with(compact('mpwsm'))->with(compact('mpws'))->with(compact('mp'));
    }

    public function updatews()
    {
        // $data = Requests::input();
        // dd($data);
        // die;

        $id_mpwsm = Requests::input('id');

        $mp = strtoupper(Requests::input('mp'));
        $no_urut = Requests::input('no_urut');
        $combo = strtoupper(Requests::input('color'));
        $total_qty = Requests::input('ws_qty_tot');

        $size_ar = Requests::input('input_size');
        $ws_qty_ar = Requests::input('input_ws_qty');
        $tolerance_ar = Requests::input('input_tolerance');
        $qty_tot_ar = Requests::input('input_qty_tot');

        // update Wsheet main
        Mp_wsheet_main::where('id', $id_mpwsm)->update([
            'no_urut'       => $no_urut,
            'combo'         => $combo,
            'total_qty'     => $total_qty
        ]);

        // Update Wsheet
        $c = count(Requests::input('input_size'));

        Mp_wsheet::where('mp_wsheet_m', $id_mpwsm)->delete();
        for ($i = 0; $i < $c; $i++) {
            Mp_wsheet::create([
                'mp'           => $mp,
                'mp_wsheet_m'  => $id_mpwsm,
                'no_urut'       =>  $no_urut,
                'combo'         =>  $combo,
                'size'          =>  strtoupper($size_ar[$i]),
                'ws_qty'        =>  $ws_qty_ar[$i],
                'tolerance'     =>  $tolerance_ar[$i],
                'qty_tot'       =>  $qty_tot_ar[$i]
            ]);

            // get id ws for assort
            $last_ws = Mp_wsheet::orderBy('created_at', 'desc')->first();
            $idws[$i] = $last_ws['id'];
        }

        // Update Assort
        $mpt = Mp_type::where('id_wsheet', $id_mpwsm)->get();

        foreach ($mpt as $t) {
            if ($t['type'] !== "PIPING") {

                $mpd = Mp_detail::where('id_type', $t['id'])->get();
                foreach ($mpd as $d) {

                    Mp_assort::where('id_mpd', $d['id'])->delete();

                    for ($i = 0; $i < $c; $i++) {
                        Mp_assort::create([
                            'mp'       => $mp,
                            'id_mpwsm' => $id_mpwsm,
                            'id_ws'     => $idws[$i],
                            'id_mpt'   => $t['id'],
                            'id_mpd'   => $d['id'],
                            'size'      => strtoupper($size_ar[$i]),
                            'qty_ws'    => $qty_tot_ar[$i],
                            'scale'     => 0
                        ]);
                    }
                }
            }
        }
        // die;

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Worksheet Berhasil Di simpan');
        return redirect('/mp/detail/' . $id_mp->id)->with('alert', 'Harap isi kembali Scale pada setiap Detail .');
    }

    public function print_wsm($id_mp, $id_mpwsm)
    {
        $mp = Mp::where('id', $id_mp)->first();
        $mpwsm = Mp_wsheet_main::where('id', $id_mpwsm)->first();
        $mpws = Mp_wsheet::where('mp_wsheet_m', $id_mpwsm)->get();
        $mpt = Mp_type::where('id_wsheet', $mpwsm['id'])
            ->where('type', 'MARKER')
            ->orWhere('type', 'KAIN KERAS')
            ->orderby('type', 'ASC')
            ->get();
        $mpd = Mp_detail::where('id_mpwsm', $id_mpwsm)->get();
        $mpa = Mp_assort::where('id_mpwsm', $id_mpwsm)->get();

        return view('marker.print_mp_wsm')->with(compact('mp'))->with(compact('mpwsm'))->with(compact('mpws'))->with(compact('mpt'))->with(compact('mpd'))->with(compact('mpa'));
    }

    public function editmpt($id_mpt, $id_mp)
    {
        $mpt = Mp_type::where('id', $id_mpt)->first();
        $mp = $id_mp;
        return view('marker.mpt_edit')->with(compact('mpt'))->with(compact('mp'));
    }

    public function updatempt()
    {
        $id_mpt = Requests::input('id');
        $mp = strtoupper(Requests::input('mp'));
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

        Mp_type::where('id', $id_mpt)->update([
            'mp' => $mp,
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

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Type Berhasil Di Update!');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function deletempt($id)
    {
        $mpt = Mp_type::where('id', $id)->first();
        $id_mp = Mp::where('number', $mpt->mp)->first();
        $mpd = Mp_detail::where('id_type', $id)->get();
        foreach ($mpd as $d) {
            Mp_assort::where('id_mpd', $d['id'])->delete();
        }

        Mp_detail_piping::where('id_type', $id)->delete();
        Mp_detail::where('id_type', $id)->delete();
        Mp_type::where('id', $id)->delete();
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function print_ws($id_mp, $id_mpwsm, $id_mpt)
    {
        $mp = Mp::where('id', $id_mp)->first();
        $mpwsm = Mp_wsheet_main::where('id', $id_mpwsm)->first();
        $mpws = Mp_wsheet::where('mp_wsheet_m', $id_mpwsm)->get();
        $mpt = Mp_type::where('id', $id_mpt)->first();
        $mpd = Mp_detail::where('id_type', $id_mpt)->get();
        $mpa = Mp_assort::where('id_mpt', $id_mpt)->get();

        return view('marker.print_mp_type')->with(compact('mp'))->with(compact('mpwsm'))->with(compact('mpws'))->with(compact('mpt'))->with(compact('mpd'))->with(compact('mpa'));
    }

    public function detail_getsize(Request $request)
    {
        $id_mpwsm = $request->get('mpwsmid');
        $hasil = Mp_wsheet::select('size', 'qty_tot')->where('mp_wsheet_m', $id_mpwsm)->get();
        return response()->json($hasil);
    }

    public function edit_getsize(Request $request)
    {
        $id_mpd = $request->get('mpd_id');
        $hasil = Mp_assort::select('id', 'size', 'qty_ws', 'scale')->where('id_mpd', $id_mpd)->get();
        return response()->json($hasil);
    }

    public function createdetail_ma(Request $request)
    {
        // === input for detail===
        $mp = strtoupper(Requests::input('ma_mp'));
        $id_mpwsm = Requests::input('ma_id_mpwsm');
        $id_type = Requests::input('ma_id_type');
        $urutan = Requests::input('ma_urutan');
        $code = strtoupper(Requests::input('ma_code'));
        $marker_date = Requests::input('ma_marker_date');
        $efisiensi = Requests::input('ma_efisiensi');
        $perimeter = Requests::input('ma_perimeter');
        $tole_pjg_m = Requests::input('ma_tole_pjg_m');
        $tole_lbr_m = Requests::input('ma_tole_lbr_m');
        $kons_sz_tgh = Requests::input('ma_kons_sz_tgh');
        $tgl_sz_tgh = Requests::input('ma_tgl_sz_tgh');
        $panjang_m = Requests::input('ma_panjang_m');
        $lebar_m = Requests::input('ma_lebar_m');
        $gramasi = Requests::input('ma_gramasi');
        $total_skala = Requests::input('ma_total_skala');
        $jml_marker = Requests::input('ma_jml_marker');
        $jml_ampar = Requests::input('ma_jml_ampar');

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('ma_pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'ma_pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = "-";
        }
        // END of upload pdf

        $komponen = strtoupper(Requests::input('ma_komponen'));
        $revisi = Requests::input('ma_revisi');
        $revisi_remark = strtoupper(Requests::input('ma_revisi_remark'));

        Mp_detail::create([
            'mp' => $mp,
            'id_mpwsm' => $id_mpwsm,
            'id_type' => $id_type,
            'urutan' => $urutan,
            'code' => $code,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
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
        $as_mpd = Mp_detail::where('mp', $mp)->latest('created_at')->first();

        $as_size = Requests::input('input_det_size');
        $as_qty = Requests::input('input_det_qty');
        $as_scale = Requests::input('input_det_scale');

        for ($i = 0; $i < $c; $i++) {
            Mp_assort::create([
                "mp" => $mp,
                "id_mpwsm" => $id_mpwsm,
                "id_ws" => 0,
                "id_mpt" => $id_type,
                "id_mpd" => $as_mpd['id'],
                "size" => strtoupper($as_size[$i]),
                "qty_ws" => $as_qty[$i],
                "scale" => $as_scale[$i]
            ]);
        }

        // get mpt where id = $id_type
        $mpt = Mp_type::where('id', $id_type)->first();
        // can use $mpt['id_wsheet']

        // get mpwsm where id = mpt['id_wsheet']
        $mpwsm = Mp_wsheet_main::where('id', $mpt['id_wsheet'])->first();
        // can use $mpwsm['id']

        // get mpws where mp_wsheet_m = $mpwsm['id']
        $mpws = Mp_wsheet::where('mp_wsheet_m', $mpwsm['id'])->orderBy('id', 'desc')->get();
        // can use $mpws['id']

        // foreach mpws -> $count++
        $count = 0;
        foreach ($mpws as $ws) {
            $id_ws[$count] = $ws['id'];
            $count++;
        }
        // can use $count for limit and $id_ws for real id_ws on update assort

        // get mpa, latest('created_at')->orderBy('id', 'asc')->limit($count)
        $mpa = Mp_assort::orderBy('id', 'desc')->limit($count)->get();

        $count2 = 0;
        foreach ($mpa as $a) {
            Mp_assort::where('id', $a['id'])->update([
                "id_ws" => $id_ws[$count2]
            ]);
            $count2++;
        }

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Detail MP Berhasil Di simpan');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function createdetail_pi(Request $request)
    {
        // === input for detail===
        $mp = strtoupper(Requests::input('pi_mp'));
        $id_mpwsm = Requests::input('pi_id_mpwsm');
        $id_type = Requests::input('pi_id_type');
        $untuk = strtoupper(Requests::input('pi_untuk'));
        $ukuran = Requests::input('pi_ukuran');
        $arah = strtoupper(Requests::input('pi_arah'));
        $urutan = Requests::input('pi_urutan');
        $kode_marker = strtoupper(Requests::input('pi_kode_marker'));
        $marker_date = Requests::input('pi_marker_date');
        $efisiensi = Requests::input('pi_efisiensi');
        $perimeter = Requests::input('pi_perimeter');
        $tole_pjg_m = Requests::input('pi_tole_pjg_m');
        $tole_lbr_m = Requests::input('pi_tole_lbr_m');
        // $pdf_marker = Requests::input('pi_pdf_marker');
        $panjang_m = Requests::input('pi_panjang_m');
        $lebar_m = Requests::input('pi_lebar_m');
        $mp_pcs = Requests::input('pi_mp_pcs');
        $pola_asli = strtoupper(Requests::input('pi_pola_asli'));
        $gramasi = Requests::input('pi_gramasi');
        $skala = Requests::input('pi_skala');
        $jml_ampar = Requests::input('pi_jml_ampar');
        $kons_sz_tgh = Requests::input('pi_kons_sz_tgh');
        $tgl_sz_tgh = Requests::input('pi_tgl_sz_tgh');
        $tot_ws_qty = Requests::input('pi_tot_ws_qty');
        $tolerance = Requests::input('pi_tolerance');
        $revision = Requests::input('pi_revision');
        $revision_remark = strtoupper(Requests::input('pi_revision_remark'));

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('pi_pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'pi_pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = "-";
        }
        // END of upload pdf

        Mp_detail_piping::create([
            'mp' => $mp,
            'id_mpwsm' => $id_mpwsm,
            'id_type' => $id_type,
            'untuk' => $untuk,
            'ukuran' => $ukuran,
            'arah' => $arah,
            'urutan' => $urutan,
            'kode_marker' => $kode_marker,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'pdf_marker' => $nama_file,
            'panjang_m' => $panjang_m,
            'lebar_m' => $lebar_m,
            'mp_pcs' => $mp_pcs,
            'pola_asli' => $pola_asli,
            'gramasi' => $gramasi,
            'skala' => $skala,
            'jml_ampar' => $jml_ampar,
            'kons_sz_tgh' => $kons_sz_tgh,
            'tgl_sz_tgh' => $tgl_sz_tgh,
            'tot_ws_qty' => $tot_ws_qty,
            'tolerance' => $tolerance,
            'revision' => $revision,
            'revision_remark' => $revision_remark
        ]);

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Detail Piping Berhasil Di simpan');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function editmpd($id_mpd, $id_mp, $id_mpwsm)
    {
        $mpwsm_id = $id_mpwsm;
        $mpd = Mp_detail::where('id', $id_mpd)->first();
        $mpa = Mp_assort::where('id_mpd', $id_mpd)->orderBy('id', 'DESC')->get();
        $mp = $id_mp;
        return view('marker.mpd_edit')->with(compact('mpwsm_id'))->with(compact('mpd'))->with(compact('mp'))->with(compact('mpa'));
    }

    public function editmpi($id_mpi, $id_mp, $id_mpwsm)
    {
        $mpwsm_id = $id_mpwsm;
        $mpi = Mp_detail_piping::where('id', $id_mpi)->first();
        $mpwsm = Mp_wsheet_main::where('id', $id_mpwsm)->first();
        $mp = $id_mp;

        return view('marker.mpd_edit_pi')->with(compact('mpwsm_id'))->with(compact('mpi'))->with(compact('mp'))->with(compact('mpwsm'));
    }

    public function updatempd_ma(Request $request)
    {
        $id = Requests::input('id');

        // update assortment
        $c = count(Requests::input('input_det_size'));

        $id_mpa = Requests::input('input_id_mpa');
        $as_qty = Requests::input('input_det_qty');
        $as_scale = Requests::input('input_det_scale');

        for ($i = 0; $i < $c; $i++) {
            Mp_assort::where('id', $id_mpa[$i])->update([
                "qty_ws" => $as_qty[$i],
                "scale" => $as_scale[$i]
            ]);
        }

        // preparation update detail
        $mp = strtoupper(Requests::input('mp'));
        // $id_mpwsm = Requets::input('mpwsm_id');
        $id_type = Requests::input('id_type');
        $urutan = Requests::input('urutan');
        $code = strtoupper(Requests::input('code'));
        $marker_date = Requests::input('marker_date');
        $efisiensi = Requests::input('efisiensi');
        $perimeter = Requests::input('perimeter');
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

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // hapus file
            $old_file = Mp_detail::where('id', $id)->first();
            File::delete('mcp_files/' . $old_file->pdf_marker);
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        }

        $komponen = strtoupper(Requests::input('komponen'));
        $revisi = Requests::input('revisi');
        $revisi_remark = strtoupper(Requests::input('revisi_remark'));

        Mp_detail::where('id', $id)->update([
            'mp' => $mp,
            // 'id_mpwsm' => $id_mpwsm,
            'id_type' => $id_type,
            'urutan' => $urutan,
            'code' => $code,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
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

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Type Berhasil Di simpan');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function updatempd_pi(Request $request)
    {
        $id = Requests::input('pi_id');

        // preparation update detail
        $mp = strtoupper(Requests::input('pi_mp'));

        $id_mpwsm = Requests::input('pi_id_mpwsm');
        $id_type = Requests::input('pi_id_type');
        $untuk = strtoupper(Requests::input('pi_untuk'));
        $ukuran = Requests::input('pi_ukuran');
        $arah = strtoupper(Requests::input('pi_arah'));
        $urutan = Requests::input('pi_urutan');
        $kode_marker = strtoupper(Requests::input('pi_kode_marker'));
        $marker_date = Requests::input('pi_marker_date');
        $efisiensi = Requests::input('pi_efisiensi');
        $perimeter = Requests::input('pi_perimeter');
        $tole_pjg_m = Requests::input('pi_tole_pjg_m');
        $tole_lbr_m = Requests::input('pi_tole_lbr_m');
        $nama_file = Requests::input('pdf_marker_name');
        $panjang_m = Requests::input('pi_panjang_m');
        $lebar_m = Requests::input('pi_lebar_m');
        $mp_pcs = strtoupper(Requests::input('pi_mp_pcs'));
        $pola_asli = strtoupper(Requests::input('pi_pola_asli'));
        $gramasi = Requests::input('pi_gramasi');
        $skala = Requests::input('pi_skala');
        $jml_ampar = Requests::input('pi_jml_ampar');
        $kons_sz_tgh = Requests::input('pi_kons_sz_tgh');
        $tgl_sz_tgh = Requests::input('pi_tgl_sz_tgh');
        $tot_ws_qty = Requests::input('pi_tot_ws_qty');
        $tolerance = Requests::input('pi_tolerance');
        $revision = Requests::input('pi_revision');
        $revision_remark = strtoupper(Requests::input('pi_revision_remark'));

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('pi_pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'pi_pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // hapus file
            $old_file = Mp_detail_piping::where('id', $id)->first();
            File::delete('mcp_files/' . $old_file->pdf_marker);
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mcp_files/';
            $file->move($tujuan_upload, $nama_file);
        }

        Mp_detail_piping::where('id', $id)->update([
            'mp' => $mp,
            'id_type' => $id_type,
            'untuk' => $untuk,
            'ukuran' => $ukuran,
            'arah' => $arah,
            'urutan' => $urutan,
            'kode_marker' => $kode_marker,
            'marker_date' => $marker_date,
            'efisiensi' => $efisiensi,
            'perimeter' => $perimeter,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'pdf_marker' => $nama_file,
            'panjang_m' => $panjang_m,
            'lebar_m' => $lebar_m,
            'mp_pcs' => $mp_pcs,
            'pola_asli' => $pola_asli,
            'gramasi' => $gramasi,
            'skala' => $skala,
            'jml_ampar' => $jml_ampar,
            'kons_sz_tgh' => $kons_sz_tgh,
            'tgl_sz_tgh' => $tgl_sz_tgh,
            'tot_ws_qty' => $tot_ws_qty,
            'tolerance' => $tolerance,
            'revision' => $revision,
            'revision_remark' => $revision_remark
        ]);

        $id_mp = Mp::where('number', $mp)->first();
        Session::flash('sukses', 'Data Piping Berhasil Di Update');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function deletempd($id)
    {
        $mpd = Mp_detail::where('id', $id)->first();
        $id_mp = Mp::where('number', $mpd->mp)->first();

        Mp_assort::where('id_mpd', $id)->delete();
        Mp_detail::where('id', $id)->delete();
        File::delete('mcp_files/' . $mpd->pdf_marker);
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function deletempi($id)
    {
        $mpi = Mp_detail_piping::where('id', $id)->first();
        $id_mp = Mp::where('number', $mpi->mp)->first();

        Mp_detail_piping::where('id', $id)->delete();
        File::delete('mcp_files/' . $mpi->pdf_marker);
        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mp/detail/' . $id_mp->id);
    }

    public function print_detmp($filename)
    {
        //PDF file is stored under project/public/download
        $file = public_path() . "/mcp_files" . "/";

        $headers = array(
            'Content-Type: application/pdf',
        );

        $pathToFile = $file . $filename;

        return response()->download($pathToFile);
    }
}
