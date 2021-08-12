<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Requests;
use Image;
use File;
use Session;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuotationImport;

use App\Quotation;
use App\QuotationDetail;
use App\QuotationImage;
use App\QuotationImports;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $result = Quotation::orderBy('code', 'asc')->paginate(10);

        if ($request->ajax()) {
            $param_name   = $request->create_by;
            $param_name2     = $request->update_by;

            if ($param_name2 <> '') {
                $result = Quotation::where('code', 'like', '%' . strtoupper($request->code) . '%')
                    ->where('cust', 'like', '%' . strtoupper($request->cust) . '%')
                    ->Where('brand', 'like', '%' . strtoupper($request->brand) . '%')
                    ->Where('style', 'like', '%' . strtoupper($request->style) . '%')
                    ->whereHas('user', function ($q) use ($param_name) {
                        $q->where('name', 'like', '%' . $param_name . '%');
                    })
                    ->whereHas('user_update', function ($q2) use ($param_name2) {
                        $q2->where('name', 'like', '%' . $param_name2 . '%');
                    })
                    ->Where('season', 'like', '%' . strtoupper($request->season) . '%')
                    ->Where('bu', 'like', '%' . strtoupper($request->bu) . '%')
                    ->orderBy('code', 'asc')
                    ->paginate(10);
            } else {
                $result = Quotation::where('code', 'like', '%' . strtoupper($request->code) . '%')
                    ->where('cust', 'like', '%' . strtoupper($request->cust) . '%')
                    ->Where('brand', 'like', '%' . strtoupper($request->brand) . '%')
                    ->Where('style', 'like', '%' . strtoupper($request->style) . '%')
                    ->whereHas('user', function ($q) use ($param_name) {
                        $q->where('name', 'like', '%' . $param_name . '%');
                    })
                    ->Where('season', 'like', '%' . strtoupper($request->season) . '%')
                    ->Where('bu', 'like', '%' . strtoupper($request->bu) . '%')
                    ->orderBy('code', 'asc')
                    ->paginate(10);
            }

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('quotation.list', array('result' => $result))->render());
            }
        }

        return view('quotation.index', ['result' => $result]);
    }

    public function view($id)
    {
        $header = Quotation::where('code', '=', $id)->get();

        $gmbr = QuotationImage::where('id_quot_header', '=', $id)->get();

        $fabric         = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'FABRIC')->get();
        $special_trims     = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'SPECIAL TRIMS')->get();
        $trims             = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'TRIMS')->get();
        $embellishment    = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'EMBELLISHMENT')->get();
        $washing         = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'WASHING')->get();
        $miscellaneous    = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'MISCELLANEOUS')->get();

        return view('quotation.view', [
            'header' => $header,
            'gmbr' => $gmbr,
            'fabric' => $fabric,
            'special_trims' => $special_trims,
            'trims' => $trims,
            'embellishment' => $embellishment,
            'washing' => $washing,
            'miscellaneous' => $miscellaneous,
        ]);
    }

    public function new_form()
    {
        return view('quotation.new_form');
    }

    public function edit_form($id)
    {
        $header = Quotation::where('code', '=', $id)->get();

        $fabric         = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'FABRIC')->get();
        $special_trims     = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'SPECIAL TRIMS')->get();
        $trims             = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'TRIMS')->get();
        $embellishment    = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'EMBELLISHMENT')->get();
        $washing         = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'WASHING')->get();
        $miscellaneous    = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'MISCELLANEOUS')->get();

        return view(
            'quotation.edit_form',
            [
                'header' => $header,
                'fabric' => $fabric,
                'special_trims' => $special_trims,
                'trims' => $trims,
                'embellishment' => $embellishment,
                'washing' => $washing,
                'miscellaneous' => $miscellaneous,
                'id_header' => $id,
            ]
        );
    }

    public function clone_form($id)
    {
        $header = Quotation::where('code', '=', $id)->get();

        $fabric     = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'FABRIC')->get();
        $special_trims  = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'SPECIAL TRIMS')->get();
        $trims      = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'TRIMS')->get();
        $embellishment  = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'EMBELLISHMENT')->get();
        $washing    = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'WASHING')->get();
        $miscellaneous  = QuotationDetail::where('id_quot_header', '=', $id)
            ->where('jenis', '=', 'MISCELLANEOUS')->get();

        return view(
            'quotation.clone_form',
            [
                'header' => $header,
                'fabric' => $fabric,
                'special_trims' => $special_trims,
                'trims' => $trims,
                'embellishment' => $embellishment,
                'washing' => $washing,
                'miscellaneous' => $miscellaneous,
                'id_header' => $id,
            ]
        );
    }

    public function create()
    {
        $c = count(Requests::input('jenis'));


        $cust           = strtoupper(Requests::input('cust'));
        $brand          = strtoupper(Requests::input('brand'));
        $season         = strtoupper(Requests::input('season'));
        $style          = strtoupper(Requests::input('style'));
        $descript         = Requests::input('descript');
        $bu             = strtoupper(Requests::input('bu'));
        $forecast_qty   = Requests::input('forecast_qty');
        $delivery       = strtoupper(Requests::input('delivery'));
        $size_range     = strtoupper(Requests::input('size_range'));
        $destination    = strtoupper(Requests::input('destination'));
        $tgl_quot       = Requests::input('tgl_quot');
        $exchange_rate     = Requests::input('exchange_rate');
        $smv            = Requests::input('smv');
        $rate           = Requests::input('rate');
        $handling       = Requests::input('handling');
        $margin         = Requests::input('margin');
        $offer_price    = Requests::input('offer_price');
        $sales_fee      = Requests::input('sales_fee');
        $confirm_price  = Requests::input('confirm_price');
        $user_id         = Requests::input('create_by');


        // Get the last order id
        $lastCode = Quotation::orderBy('code', 'desc')->first();

        // Get last 3 digits of last order code
        if (!$lastCode) {
            $lastNumber = 'Q' . date('Y') . '-' . str_pad(0, 5, 0, STR_PAD_LEFT);
        } else {
            $lastNumber = $lastCode['code'];
        }
        $lastIncreament = substr($lastNumber, -5);

        // Make a new order code with appending last increment + 1
        $newCode = 'Q' . date('Y') . '-' . str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);

        Quotation::create([
            'code'            => $newCode,
            'cust'            => $cust,
            'brand'           => $brand,
            'season'          => $season,
            'style'           => $style,
            'description'     => $descript,
            'bu'              => $bu,
            'forecast_qty'    => $forecast_qty,
            'delivery'        => $delivery,
            'size_range'      => $size_range,
            'destination'     => $destination,
            'tgl_quot'        => date($tgl_quot),
            'exchange_rate'   => $exchange_rate,
            'smv'             => $smv,
            'rate'            => $rate,
            'handling'        => $handling,
            'margin'          => $margin,
            'offer_price'     => $offer_price,
            'sales_fee'       => $sales_fee,
            'confirm_price'   => $confirm_price,
            'status'          => 'pending',
            'create_by'       => $user_id,
        ]);

        // $quotation_header 					= new Quotation;
        // $quotation_header->cust 			= $cust;
        // $quotation_header->brand 			= $brand;
        // $quotation_header->season 			= $season;
        // $quotation_header->style 			= $style;
        // $quotation_header->description 		= $descript;
        // $quotation_header->bu 				= $bu;
        // $quotation_header->forecast_qty 	= $forecast_qty;
        // $quotation_header->delivery 		= $delivery;
        // $quotation_header->size_range 		= $size_range;
        // $quotation_header->destination 		= $destination;
        // $quotation_header->tgl_quot 		= date($tgl_quot);
        // $quotation_header->exchange_rate 	= $exchange_rate;
        // $quotation_header->smv 				= $smv;
        // $quotation_header->rate 			= $rate;
        // $quotation_header->handling 		= $handling;
        // $quotation_header->margin 			= $margin;
        // $quotation_header->offer_price 		= $offer_price;
        // $quotation_header->sales_fee 		= $sales_fee;
        // $quotation_header->confirm_price 	= $confirm_price;
        // $quotation_header->create_by		= $user_id;
        // $quotation_header->save();

        $tahun         = date('Y');
        $bulan         = date('m');


        $files          = Input::file('gmbr');
        $nama_user       = strtoupper(Requests::input('create_by_name'));

        if ($files) {
            foreach ($files as $file) {
                // menyimpan data file yang diupload ke variabel $file
                $folder_upload     = strtoupper('storage/QUOTATION_SKETCH/' . $tahun . '/' . $bulan);

                $nama_file = time() . "_" . $nama_user . "_" . $file->getClientOriginalName();

                $file->move($folder_upload, $nama_file);

                $quotation_image                     = new QuotationImage;
                $quotation_image->id_quot_header    = $newCode;
                $quotation_image->file                 = $folder_upload . '/' . $nama_file;
                $quotation_image->save();
            }
        }
        $jenis          = Requests::input('jenis');
        $position       = Requests::input('position');
        $jenis_detail   = Requests::input('jenis_detail');
        $description    = Requests::input('description');
        $supplier       = Requests::input('supplier');
        $width          = Requests::input('width');
        $cons              = Requests::input('cons');
        $allowance      = Requests::input('allowance');
        $price              = Requests::input('price');
        $freight          = Requests::input('freight');

        for ($i = 0; $i < $c; ++$i) {
            $quotation_detail                             = new QuotationDetail;
            $quotation_detail->id_quot_header     = $newCode;
            $quotation_detail->jenis                = $jenis[$i];
            $quotation_detail->position           = $position[$i];
            $quotation_detail->jenis_detail     = $jenis_detail[$i];
            $quotation_detail->description         = $description[$i];
            $quotation_detail->supplier           = $supplier[$i];
            $quotation_detail->width                 = $width[$i];
            $quotation_detail->cons                 = $cons[$i];
            $quotation_detail->allowance           = $allowance[$i];
            $quotation_detail->price                 = $price[$i];
            $quotation_detail->freight               = $freight[$i];
            $quotation_detail->save();
        }
        //return redirect()->back();
        return redirect('/quotation/view/' . $newCode);
    }

    public function update()
    {
        $c = count(Requests::input('jenis'));

        $id_header           = Requests::input('id_header');
        $cust           = strtoupper(Requests::input('cust'));
        $brand          = strtoupper(Requests::input('brand'));
        $season         = strtoupper(Requests::input('season'));
        $style          = strtoupper(Requests::input('style'));
        $descript         = Requests::input('descript');
        $bu             = strtoupper(Requests::input('bu'));
        $forecast_qty   = Requests::input('forecast_qty');
        $delivery       = strtoupper(Requests::input('delivery'));
        $size_range     = strtoupper(Requests::input('size_range'));
        $destination    = strtoupper(Requests::input('destination'));
        $tgl_quot       = Requests::input('tgl_quot');
        $exchange_rate     = Requests::input('exchange_rate');
        $smv            = Requests::input('smv');
        $rate           = Requests::input('rate');
        $handling       = Requests::input('handling');
        $margin         = Requests::input('margin');
        $offer_price    = Requests::input('offer_price');
        $sales_fee      = Requests::input('sales_fee');
        $confirm_price  = Requests::input('confirm_price');
        $user_id             = Requests::input('update_by');
        $tgl_update          = date(NOW());

        Quotation::where('code', $id_header)->update([
            'cust'            => $cust,
            'brand'           => $brand,
            'season'          => $season,
            'style'           => $style,
            'description'     => $descript,
            'bu'              => $bu,
            'forecast_qty'    => $forecast_qty,
            'delivery'        => $delivery,
            'size_range'      => $size_range,
            'destination'     => $destination,
            'tgl_quot'        => date($tgl_quot),
            'exchange_rate'   => $exchange_rate,
            'smv'             => $smv,
            'rate'            => $rate,
            'handling'        => $handling,
            'margin'          => $margin,
            'offer_price'     => $offer_price,
            'sales_fee'       => $sales_fee,
            'confirm_price'   => $confirm_price,
            'update_by'       => $user_id,
            'update_tgl'      => $tgl_update,
        ]);
        // $quotation_header 					       = Quotation::find($id_header);
        // $quotation_header->cust 			     = $cust;
        // $quotation_header->brand 			     = $brand;
        // $quotation_header->season 			   = $season;
        // $quotation_header->style 			     = $style;
        // $quotation_header->description 		 = $descript;
        // $quotation_header->bu 				     = $bu;
        // $quotation_header->forecast_qty 	 = $forecast_qty;
        // $quotation_header->delivery 		   = $delivery;
        // $quotation_header->size_range 		 = $size_range;
        // $quotation_header->destination 		 = $destination;
        // $quotation_header->tgl_quot 		   = date($tgl_quot);
        // $quotation_header->exchange_rate 	 = $exchange_rate;
        // $quotation_header->smv 				     = $smv;
        // $quotation_header->rate 			     = $rate;
        // $quotation_header->handling 		   = $handling;
        // $quotation_header->margin 			   = $margin;
        // $quotation_header->offer_price 		 = $offer_price;
        // $quotation_header->sales_fee 		   = $sales_fee;
        // $quotation_header->confirm_price 	 = $confirm_price;
        // $quotation_header->update_by		   = $user_id;
        // $quotation_header->update_tgl		   = $tgl_update;
        // $quotation_header->save();


        $tahun         = date('Y');
        $bulan         = date('m');

        $files          = Input::file('gmbr');
        $nama_user       = strtoupper(Requests::input('create_by_name'));

        if ($files) {
            // hapus file
            $gambar = QuotationImage::where('id_quot_header', $id_header)->get();
            foreach ($gambar as $g) {
                File::delete($g->file);
            }
            QuotationImage::where('id_quot_header', $id_header)->delete();

            foreach ($files as $file) {
                // menyimpan data file yang diupload ke variabel $file
                $folder_upload     = strtoupper('storage/QUOTATION_SKETCH/' . $tahun . '/' . $bulan);

                $nama_file = time() . "_" . $nama_user . "_" . $file->getClientOriginalName();

                $file->move($folder_upload, $nama_file);

                $quotation_image                     = new QuotationImage;
                $quotation_image->id_quot_header    = $id_header;
                $quotation_image->file                 = $folder_upload . '/' . $nama_file;
                $quotation_image->save();
            }
        }
        $jenis          = Requests::input('jenis');
        $position       = Requests::input('position');
        $jenis_detail   = Requests::input('jenis_detail');
        $description    = Requests::input('description');
        $supplier       = Requests::input('supplier');
        $width          = Requests::input('width');
        $cons              = Requests::input('cons');
        $allowance      = Requests::input('allowance');
        $price              = Requests::input('price');
        $freight          = Requests::input('freight');

        QuotationDetail::where('id_quot_header', $id_header)->delete();

        for ($i = 0; $i < $c; ++$i) {
            $quotation_detail                             = new QuotationDetail;
            $quotation_detail->id_quot_header     = $id_header;
            $quotation_detail->jenis                = $jenis[$i];
            $quotation_detail->position           = $position[$i];
            $quotation_detail->jenis_detail     = $jenis_detail[$i];
            $quotation_detail->description         = $description[$i];
            $quotation_detail->supplier           = $supplier[$i];
            $quotation_detail->width                 = $width[$i];
            $quotation_detail->cons                 = $cons[$i];
            $quotation_detail->allowance           = $allowance[$i];
            $quotation_detail->price                 = $price[$i];
            $quotation_detail->freight               = $freight[$i];
            $quotation_detail->save();
        }
        //return redirect()->back();
        return redirect('/quotation/view/' . $id_header);
    }

    public function import()
    {
        return view('quotation.import');
    }

    public function getValue(Request $request)
    {

        // menangkap file excel
        $file = $request->file('file');

        $nama_file = $file->getClientOriginalName();

        $history = QuotationImports::where('filename', $nama_file)->where('status_import', '=', 'Sukses')->first();

        if (!$history) {
            // upload ke folder file_siswa di dalam folder public
            $file->move('storage/temp_excel', 'temp_.xlsm');
            // import data
            $file_temp = 'storage/temp_excel/temp_.xlsm';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path($file_temp));

            for ($i = 2; $i <= $spreadsheet->getSheetCount() - 1; $i++) {
                $import = new QuotationImport($i, $file_temp);
                $import->onlySheets($i);

                $imp = Excel::import($import, public_path($file_temp));
            }

            File::delete($file_temp);

            if ($imp) {
                DB::table('quotation')->whereNull('cust')
                    ->update([
                        'cust' => ''
                    ]);
                DB::table('quotation')->whereNull('brand')
                    ->update([
                        'brand' => ''
                    ]);
                DB::table('quotation')->whereNull('season')
                    ->update([
                        'season' => ''
                    ]);
                DB::table('quotation')->whereNull('style')
                    ->update([
                        'style' => ''
                    ]);
                DB::table('quotation')->whereNull('bu')
                    ->update([
                        'bu' => ''
                    ]);

                $hist = new QuotationImports;
                $hist->filename       = $nama_file;
                $hist->import_user    = Auth::user()->name;
                $hist->status_import  = 'Sukses';
                $hist->save();
                // notifikasi dengan session
                Session::flash('sukses', 'Quotation file ' . $nama_file . ' Berhasil Diimport!');
                return redirect('/quotation/import');
            } else {
                $hist = new QuotationImports;
                $hist->filename       = $nama_file;
                $hist->import_user    = Auth::user()->name;
                $hist->status_import  = 'Gagal';
                $hist->save();
                // notifikasi dengan session
                Session::flash('error', 'Quotation file ' . $nama_file . ' Gagal Diimport!');
                return redirect('/quotation/import');
            }
        } else {
            // notifikasi dengan session
            Session::flash('error', 'Quotation file ' . $nama_file . ' Sudah pernah Diimport Mohon di pastikan kembali!');
            return redirect('/quotation/import');
        }
    }
}
