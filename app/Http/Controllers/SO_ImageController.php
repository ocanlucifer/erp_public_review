<?php

namespace App\Http\Controllers;

use App\SO_Image;
use App\Salesorder;

use Illuminate\Http\Request;
use File;
use Session;
use Auth;

class SO_ImageController extends Controller
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

    public function index($idsalesorder)
    {
        $result = SO_Image::orderBy('id', 'asc')->paginate(10);
        return view('sales_order.images', ['result' => $result]);
    }

    public function upload($idsalesorder, Request $request)
    {
        $gambar = SO_Image::where('id_sales_order', $idsalesorder)
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
            $tujuan_upload = 'sales_file/order';
            $file->move($tujuan_upload, $nama_file);

            SO_Image::create([
                'id_sales_order' => $idsalesorder,
                'image_type' => $request->image_type,
                'source' => $nama_file
            ]);

            Session::flash('sukses', 'Data Gambar ' . strtoupper($request->image_type) . ' Berhasil Di Tambahkan');
        }

        return redirect('/salesorders/image/' . $idsalesorder);
    }

    public function edit($id, $idsalesorder)
    {
        $result = SO_Image::where('id', $id)->first();
        return view('sales_order.images_edit', ['result' => $result]);

        if ($this->input->post()) {
            'aaa';
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $idsalesorder = $request->id_sales_order;

        $this->validate($request, [
            'source' => 'required|file|image|mimes:png,jpg,jpeg|max:2048',
            'image_type' => 'required'
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('source');
        $nama_file = time() . "_" . $file->getClientOriginalName();

        // hapus file
        $gambar = SO_Image::where('id', $id)->first();
        File::delete('sales_file/order/' . $gambar->source);

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'sales_file/order';
        $file->move($tujuan_upload, $nama_file);

        SO_Image::where('id', $id)->update([
            'id_sales_order' => $idsalesorder,
            'image_type' => $request->image_type,
            'source' => $nama_file
        ]);

        Session::flash('sukses', 'Data Gambar ' . strtoupper($request->image_type) . ' Berhasil Di Update');
        return redirect('/salesorders/image/' . $idsalesorder);
    }

    public function delete($id, $idsalesorder)
    {
        // hapus file
        $gambar = SO_Image::where('id', $id)->first();
        File::delete('sales_file/order/' . $gambar->source);

        // hapus data
        SO_Image::where('id', $id)->delete();

        Session::flash('sukses', 'Data Gambar Berhasil Di Hapus');
        return redirect('/salesorders/image/' . $idsalesorder);
    }
}
