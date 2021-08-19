<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Requests;
use File;
use Session;
use Auth;
use App\Poacc;
use App\Salesorder;

class PoaccController extends Controller
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
        $result = Poacc::orderby('id', 'DESC')->paginate(10);

        if ($request->ajax()) {
            $result = Poacc::where('number', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('supplier', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orWhere('state', 'like', '%' . strtoupper($request->keyword) . '%')
                ->orderBy('number', 'DESC')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('purchasing.poacc.poacc_list', array('result' => $result))->render());
            }
        }
        return view('purchasing.poacc.poacc_index', ['result' => $result]);
    }

    public function create(Request $request)
    {
        // inisialisasi data
        $data = Requests::input();
        $sum_data = Poacc::where('number', 'like', '%' . $data['new_numbering'] . '%')->get();
        $kode = sprintf("%05s", count($sum_data) + 1);

        Poacc::create([
            'number' => $data['new_numbering'] . '/' . $kode,
            'supplier' => strtoupper($data['new_supplier']),
            'currency' => strtoupper($data['new_currency']),
            'exchange_rate' => $data['new_exchange_rate'],
            'order_date' => $data['new_order_date'],
            'start_date' => $data['new_start_date'],
            'end_date' => $data['new_end_date'],
            'price_term' => strtoupper($data['new_price_term']),
            'payment_term' => strtoupper($data['new_payment_term']),
            'bank_charges' => $data['new_bank_charges'],
            'note' => strtoupper($data['new_note']),
            'rounding_value' => $data['new_rounding_value'],
            'allowance_qty' => $data['new_allowance_qty'],
            'state' => strtoupper('pending'),
            'printed_count' => 0,
            'created_by' => strtoupper(Auth::user()->name)
        ]);
        Session::flash('sukses', 'Data Po Accessories Berhasil Ditambahkan');
        return redirect('/purchasing/acc_orders');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $result['po'] = poacc::where('id', $id)->first();
        $result['currency'] = ['RUPIAH', 'US DOLLAR'];
        $result['bank_charges'] = ['FULL AMOUNT', 'SHARED', 'SUPPLIER'];
        return response()->json($result);
    }

    public function update(Request $request)
    {
        // inisialisasi data
        $data = Requests::input();

        Poacc::where('id', $data['edit_id'])->update([
            'supplier' => strtoupper($data['edit_supplier']),
            'currency' => strtoupper($data['edit_currency']),
            'exchange_rate' => $data['edit_exchange_rate'],
            'order_date' => $data['edit_order_date'],
            'start_date' => $data['edit_start_date'],
            'end_date' => $data['edit_end_date'],
            'price_term' => strtoupper($data['edit_price_term']),
            'payment_term' => strtoupper($data['edit_payment_term']),
            'bank_charges' => strtoupper($data['edit_bank_charges']),
            'note' => strtoupper($data['edit_note']),
            'rounding_value' => $data['edit_rounding_value'],
            'allowance_qty' => $data['edit_allowance_qty'],
            'state' => strtoupper('pending'),
            'updated_by' => strtoupper(Auth::user()->name)
        ]);
        Session::flash('sukses', 'Data Po Accessories Berhasil Diupdate');
        return redirect('/purchasing/acc_orders/' . $data['edit_id']);
    }

    public function delete($id)
    {
        Poacc::where('id', $id)->delete();
        Session::flash('sukses', 'Data Po Accessories Berhasil Dihapus');
        return redirect('/purchasing/acc_orders');
    }

    public function filter($filter)
    {
        $result = Poacc::where('state', $filter)
            ->orderBy('number', 'desc')
            ->paginate(10);
        return \Response::json(\View::make('purchasing.poacc.poacc_list', array('result' => $result))->render());
    }

    public function detail($id)
    {
        $acc = Poacc::where('id', $id)->first();
        return view('purchasing.poacc.acc_index')->with(compact('acc'));
    }

    public function getMaterial()
    {
        $result = Salesorder::orderby('id', 'DESC')->paginate(10);
        return response()->json($result);
    }
}
