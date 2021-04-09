<?php

namespace App\Http\Controllers;

use App\SampleImage;
use App\Salessample;

use Illuminate\Http\Request;
use Requests;
use File;
use Session;
use Auth;

class SampleImageController extends Controller
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

    public function index($idsalessample)
    {
        $result = SampleImage::orderBy('id', 'asc')->paginate(10);
        return view('sales_sample.images', ['result' => $result]);
    }

    public function upload($idsalessample, Request $request)
    {
        $gambar = SampleImage::where('id_sales_sample', $idsalessample)
            ->where('image_type', $request->image_type)->count();

        if ($gambar > 0) {
            Session::flash('error', 'Data Gambar ' . strtoupper($request->image_type) . ' Gagal Di Tambahkan. Cek Kembali Data Yang Sudah Ada');
        } else {
            $this->validate($request, [
                'source' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
                'image_type' => 'required'
            ]);

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('source');
            $nama_file = time() . "_" . $file->getClientOriginalName();

            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'sales_file/sample';
            $file->move($tujuan_upload, $nama_file);

            SampleImage::create([
                'id_sales_sample' => $idsalessample,
                'image_type' => $request->image_type,
                'source' => $nama_file
            ]);

            Session::flash('sukses', 'Data Gambar ' . strtoupper($request->image_type) . ' Berhasil Di Tambahkan');
        }

        return redirect('/salessamples/image/' . $idsalessample);
    }

    public function edit($id, $idsalessample)
    {
        $result = SampleImage::where('id', $id)->first();
        return view('sales_sample.images_edit', ['result' => $result]);

        if ($this->input->post()) {
            'aaa';
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $idsalessample = $request->id_sales_sample;

        $this->validate($request, [
            'source' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
            'image_type' => 'required'
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('source');
        $nama_file = time() . "_" . $file->getClientOriginalName();

        // hapus file
        $gambar = SampleImage::where('id', $id)->first();
        File::delete('sales_file/sample/' . $gambar->source);

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'sales_file/sample';
        $file->move($tujuan_upload, $nama_file);

        SampleImage::where('id', $id)->update([
            'id_sales_sample' => $idsalessample,
            'image_type' => $request->image_type,
            'source' => $nama_file
        ]);

        Session::flash('sukses', 'Data Gambar ' . strtoupper($request->image_type) . ' Berhasil Di Update');
        return redirect('/salessamples/image/' . $idsalessample);
    }

    public function delete($id, $idsalessample)
    {
        // hapus file
        $gambar = SampleImage::where('id', $id)->first();
        File::delete('sales_file/sample/' . $gambar->source);

        // hapus data
        SampleImage::where('id', $id)->delete();

        Session::flash('sukses', 'Data Gambar Berhasil Di Hapus');
        return redirect('/salessamples/image/' . $idsalessample);
    }
}
