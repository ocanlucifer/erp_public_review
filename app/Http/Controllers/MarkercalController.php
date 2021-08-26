<?php

namespace App\Http\Controllers;

use App\Markercal;
use App\Markercal_d;
use App\Markercal_g;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;

class MarkercalController extends Controller
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
        $result = Markercal::orderby('mc_number', 'DESC')->paginate(10);

        if ($request->ajax()) {
            $result = Markercal::where('mc_number', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('order', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orderBy('mc_number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('marker.mc_list', array('result' => $result))->render());
            }
        }
        return view('marker.mc_index', ['result' => $result]);
    }

    public function create()
    {
        // inisialisasi data
        $id = Requests::input('id');
        $order = strtoupper(Requests::input('order'));
        $style = strtoupper(Requests::input('style'));
        $combo = strtoupper(Requests::input('combo'));
        $numbering = Requests::input('numbering');
        $fabricconst = strtoupper(Requests::input('fabricconst'));
        $fabriccomp = strtoupper(Requests::input('fabriccomp'));
        $revision = Requests::input('revision');
        $memo = Requests::input('memo');
        $created_by = strtoupper(Auth::user()->name);
        $updated_by = '-';

        // generate number
        $no = Markercal::max('mc_number');
        if (!empty($no)) {
            $number_set = ((int)substr($no, 6));
            $number_set += 1;
        } else {
            $number_set = 00001;
        }

        $year = date('y');
        $nomor = "MC/" . $year . "/";
        $number_set = $nomor . sprintf("%05s", $number_set);
        $mc_number = $number_set;

        Markercal::create([
            'mc_number' => $mc_number,
            'order' => $order,
            'style' => $style,
            'combo' => $combo,
            'numbering' => $numbering,
            'fabricconst' => $fabricconst,
            'fabriccomp' => $fabriccomp,
            'revision' => $revision,
            'memo' => $memo,
            'created_by' => strtoupper($created_by),
            'updated_by' => $updated_by
        ]);

        Session::flash('sukses', 'Tambah data marker calculation berhasil.');
        return redirect('/markercal');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $mc = Markercal::where('id', $id)->first();
        return response()->json($mc);
    }

    public function update(Request $request)
    {
        // inisialisasi data
        $id = Requests::input('id');
        $mc_number = strtoupper(Requests::input('mc_number'));
        $order = strtoupper(Requests::input('order'));
        $style = strtoupper(Requests::input('style'));
        $combo = strtoupper(Requests::input('combo'));
        $fabricconst = strtoupper(Requests::input('fabricconst'));
        $fabriccomp = strtoupper(Requests::input('fabriccomp'));
        $revision = Requests::input('revision');
        $memo = Requests::input('memo');
        $updated_by = strtoupper(Auth::user()->name);

        $result['pesan'] = 'sukses';
        Markercal::where('id', $id)->update([
            'order' => $order,
            'style' => $style,
            'combo' => $combo,
            'fabricconst' => $fabricconst,
            'fabriccomp' => $fabriccomp,
            'revision' => $revision,
            'memo' => $memo,
            'updated_by' => $updated_by
        ]);

        Session::flash('sukses', 'Update data marker calculation berhasil ');
        redirect('markercal/mcd/' . $id);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id_markercal', $id)->get();
        if (count($mcd) > 0) {
            foreach ($mcd as $d) {
                $mcg = Markercal_g::where('id_markercal_d', $d['id'])->get();
                if (count($mcg) > 0) {
                    Markercal_g::where('id_markercal_d', $d['id'])->delete();
                }
            }
        }

        $mc = Markercal::where('id', $id)->get();
        if (count($mc) > 0) {
            foreach ($mc as $c) {
                $mcd = Markercal_d::where('id_markercal', $id)->get();
                if (count($mcd) > 0) {
                    Markercal_d::where('id_markercal', $id)->delete();
                }
            }
        }

        Markercal::where('id', $id)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/markercal');
    }

    public function confirm(Request $request)
    {
        $id = $request->id;
        Markercal::where('id', $id)->update([
            'state' => strtoupper('confirmed'),
            'updated_by' => strtoupper(Auth::user()->name)
        ]);

        Markercal_d::where('id_markercal', $id)->update([
            'state' => strtoupper('confirmed')
        ]);

        return response()->json('sukses');
    }

    public function unconfirm(Request $request)
    {
        $id = $request->id;
        Markercal::where('id', $id)->update([
            'state' => strtoupper('unconfirmed'),
            'updated_by' => strtoupper(Auth::user()->name)
        ]);

        Markercal_d::where('id_markercal', $id)->update([
            'state' => strtoupper('unconfirmed')
        ]);

        return response()->json('sukses');
    }

    public function print(Request $request)
    {
        $id = $request->id;
        $mc = Markercal::where('id', $id)->first();
        $markercal_d = Markercal_d::where('id_markercal', $id)->get();

        return view('marker.print_mc')->with(compact('mc'))->with(compact('markercal_d'));
    }

    public function mcd($id)
    {
        $mc = Markercal::where('id', $id)->first();
        $mcd = Markercal_d::where('id_markercal', $id)->get();
        return view('marker.mcd_index')->with(compact('mc'))->with(compact('mcd'));
    }

    public function mcd_create(Request $request)
    {
        $data = Requests::input();

        // inisialisasi data
        $id_markercal = Requests::input('d_id_markercal');
        $fabricconst = strtoupper(Requests::input('d_fabricconst'));
        $fabriccomp = strtoupper(Requests::input('d_fabriccomp'));
        $kode = strtoupper(Requests::input('d_kode'));
        $calculation_date = Requests::input('d_cal_date');
        $size_name = strtoupper(Requests::input('d_size_name'));

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('d_pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'd_pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mc_files/';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $nama_file = "-";
        }
        // END of upload pdf

        $pdf_marker = $nama_file;
        $pjg_m = Requests::input('d_pjg_m');
        $lbr_m = Requests::input('d_lbr_m');
        $tole_pjg_m = Requests::input('d_tole_pjg_m');
        $tole_lbr_m = Requests::input('d_tole_lbr_m');
        $efficiency = Requests::input('d_efficiency');
        $perimeter = Requests::input('d_perimeter');
        $total_scale = Requests::input('d_total_scale');
        $color_name = strtoupper(Requests::input('d_color_name'));
        $revision = Requests::input('d_revision');
        $fabric_type = strtoupper(Requests::input('d_fabric_type'));
        $remark = Requests::input('d_remark');
        $revision_remark = Requests::input('revision_remark');
        $ordering = Requests::input('d_ordering');
        $state = strtoupper('unconfirmed');

        Markercal_d::create([
            'id_markercal' => $id_markercal,
            'fabricconst' => $fabricconst,
            'fabriccomp' => $fabriccomp,
            'kode' => $kode,
            'calculation_date' => $calculation_date,
            'size_name' => $size_name,
            'pdf_marker' => $pdf_marker,
            'pjg_m' => $pjg_m,
            'lbr_m' => $lbr_m,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'efficiency' => $efficiency,
            'perimeter' => $perimeter,
            'total_scale' => $total_scale,
            'color_name' => $color_name,
            'revision' => $revision,
            'fabric_type' => $fabric_type,
            'remark' => $remark,
            'revisionRemark' => $revision_remark,
            'ordering' => $ordering,
            'state' => $state
        ]);

        Session::flash('sukses', 'Tambah data marker calculation berhasil.');
        return redirect('mcd/' . $id_markercal);
    }

    public function mcd_edit(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id', $id)->first();

        return response()->json($mcd);
    }

    public function mcd_update(Request $request)
    {
        // inisialisasi data
        $id = Requests::input('ed_id');
        $id_markercal = Requests::input('ed_id_markercal');
        $fabricconst = strtoupper(Requests::input('ed_fabricconst'));
        $fabriccomp = strtoupper(Requests::input('ed_fabriccomp'));
        $kode = strtoupper(Requests::input('ed_kode'));
        $calculation_date = Requests::input('ed_cal_date');
        $size_name = strtoupper(Requests::input('ed_size_name'));

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file_ed_pdf_marker');
        if ($file) {
            // validasi
            $this->validate($request, [
                'file_ed_pdf_marker' => 'required|file|mimes:pdf|max:4096',
            ]);

            $arr_file = explode(".", $file->getClientOriginalName());
            $nama_file = $arr_file[0] . "_" . time() . "." . $arr_file[1];

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'mc_files/';
            $file->move($tujuan_upload, $nama_file);
        } else {
            $old_data = Markercal_d::where('id', $id)->first();
            $nama_file = $old_data->pdf_marker;
        }
        // END of upload pdf

        $pdf_marker = $nama_file;
        $pjg_m = Requests::input('ed_pjg_m');
        $lbr_m = Requests::input('ed_lbr_m');
        $tole_pjg_m = Requests::input('ed_tole_pjg_m');
        $tole_lbr_m = Requests::input('ed_tole_lbr_m');
        $efficiency = Requests::input('ed_efficiency');
        $perimeter = Requests::input('ed_perimeter');
        $total_scale = Requests::input('ed_total_scale');
        $color_name = strtoupper(Requests::input('ed_color_name'));
        $revision = Requests::input('ed_revision');
        $fabric_type = strtoupper(Requests::input('ed_fabric_type'));
        $remark = Requests::input('ed_remark');
        $revision_remark = Requests::input('revision_remark');
        $ordering = Requests::input('ed_ordering');
        $state = strtoupper('unconfirmed');

        Markercal_d::where('id', $id)->update([
            // 'id_markercal' => $id_markercal,
            'fabricconst' => $fabricconst,
            'fabriccomp' => $fabriccomp,
            'kode' => $kode,
            'calculation_date' => $calculation_date,
            'size_name' => $size_name,
            'pdf_marker' => $pdf_marker,
            'pjg_m' => $pjg_m,
            'lbr_m' => $lbr_m,
            'tole_pjg_m' => $tole_pjg_m,
            'tole_lbr_m' => $tole_lbr_m,
            'efficiency' => $efficiency,
            'perimeter' => $perimeter,
            'total_scale' => $total_scale,
            'color_name' => $color_name,
            'revision' => $revision,
            'fabric_type' => $fabric_type,
            'remark' => $remark,
            'revisionRemark' => $revision_remark,
            'ordering' => $ordering,
            'state' => $state
        ]);

        Session::flash('sukses', 'Update data marker calculation detail berhasil.');
        return redirect('mcd/' . $id_markercal);
    }

    public function mcd_delete(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id', $id)->get();
        $id_markercal = $mcd[0]['id_markercal'];

        Markercal_d::where('id', $id)->delete();
        Markercal_g::where('id_markercal_d', $id)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcd' . '/' . $id_markercal);
    }

    public function mcd_confirm(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id', $id)->get();
        $id_markercal = $mcd[0]['id_markercal'];

        Markercal_d::where('id', $id)->update([
            'state' => 'CONFIRMED'
        ]);

        Session::flash('sukses', 'data marker calculation detail berhasil dikonfirmasi.');
        return redirect('mcd/' . $id_markercal);
    }

    public function mcd_unconfirm(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id', $id)->get();
        $id_markercal = $mcd[0]['id_markercal'];

        Markercal_d::where('id', $id)->update([
            'state' => 'UNCONFIRMED'
        ]);
        Session::flash('sukses', 'data marker calculation detail berhasil dikonfirmasi.');
        return redirect('mcd/' . $id_markercal);
    }

    public function mcd_print(Request $request)
    {
        $id = $request->id;
        $mcd = Markercal_d::where('id', $id)->first();

        return view('marker.print_mcd')->with(compact('mcd'));
    }

    public function get_mcg()
    {
        $id_markercal_d = Requests::input('id_mcd');
        $mcg = Markercal_g::where('id_markercal_d', $id_markercal_d)->get();
        return response()->json($mcg);
    }

    public function createG(Request $request)
    {
        $id_markercal_d = $request->g_id_markercal_d;
        $markercal_d = Markercal_d::where('id', $id_markercal_d)->first();
        $id_markercal = $markercal_d['id_markercal'];

        $kgdz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) * ($markercal_d['lbr_m'] + $markercal_d['tole_lbr_m']) * $request->g_gramasi / 1000 / $markercal_d['total_scale'] * 12, 2);
        $yddz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) / (0.914) / $markercal_d['total_scale'] * 12, 2);
        $mddz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) / $markercal_d['total_scale'] * 12, 2);

        Markercal_g::create([
            'id_markercal_d' => $id_markercal_d,
            'gramasi' => $request->g_gramasi,
            'kgdz' => $kgdz,
            'yddz' => $yddz,
            'mddz' => $mddz
        ]);
        Session::flash('sukses', 'Tambah data gramasi marker calculation berhasil.');
        return redirect('mcd/' . $id_markercal);
    }

    public function editG(Request $request)
    {
        $id_mcg = $request->id_mcg;
        $mcg = Markercal_g::where('id_markercal_g', $id_mcg)->first();
        return response()->json($mcg);
    }

    public function updateG(Request $request)
    {
        $id_markercal_g = $request->eg_id_markercal_g;
        $id_markercal_d = $request->eg_id_markercal_d;
        $markercal_d = Markercal_d::where('id', $id_markercal_d)->first();
        $id_markercal = $markercal_d['id_markercal'];

        $kgdz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) * ($markercal_d['lbr_m'] + $markercal_d['tole_lbr_m']) * $request->eg_gramasi / 1000 / $markercal_d['total_scale'] * 12, 2);
        $yddz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) / (0.914) / $markercal_d['total_scale'] * 12, 2);
        $mddz = round(($markercal_d['pjg_m'] + $markercal_d['tole_pjg_m']) / $markercal_d['total_scale'] * 12, 2);

        Markercal_g::where('id_markercal_g', $id_markercal_g)->update([
            'id_markercal_d' => $id_markercal_d,
            'gramasi' => $request->eg_gramasi,
            'kgdz' => $kgdz,
            'yddz' => $yddz,
            'mddz' => $mddz
        ]);
        Session::flash('sukses', 'Update data gramasi marker calculation berhasil.');
        return redirect('mcd/' . $id_markercal);
    }

    public function deleteG($id)
    {
        $id_mcg = $id;
        $mcg = Markercal_g::where('id_markercal_g', $id_mcg)->first();
        $id_mcd = $mcg['id_markercal_d'];
        $mcd = Markercal_d::where('id', $id_mcd)->first();
        $id_mc = $mcd['id_markercal'];

        Markercal_g::where('id_markercal_g', $id_mcg)->delete();

        Session::flash('sukses', 'Data berhasil dihapus');
        return redirect('/mcd' . '/' . $id_mc);
    }
}
