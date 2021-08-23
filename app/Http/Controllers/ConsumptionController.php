<?php

namespace App\Http\Controllers;

use App\Consumption;
use App\ConsumptionDetail;
use App\ConsumptionDetailSupplier;
use App\ConsumptionDetailFabricItem;
use App\ConsumptionDetailCollarCuffItem;
use App\ConsumptionDetailCollarCuffItemSize;
use App\Quotation;
use Illuminate\Http\Request;

use Requests;
use File;
use Session;
use Auth;

class ConsumptionController extends Controller
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
        $result = Consumption::orderby('consumptions.id', 'asc')
            ->paginate(10);

        if ($request->ajax()) {
            $result = Consumption::where('code', 'like', '%' . $request->code . '%')
                ->Where('customer', 'like', '%' . $request->customer . '%')
                ->Where('customer_style', 'like', '%' . $request->customer_style . '%')
                ->Where('code_quotation', 'like', '%' . $request->code_quotation . '%')
                ->orderBy('id', 'asc')
                ->paginate(10);

            $result->appends($request->all());
            if ($result) {
                return \Response::json(\View::make('consumption.list', array('result' => $result))->render());
            }
        }
        return view('consumption.index', ['result' => $result]);
    }

    public function delete($id)
    {
        Consumption::where('id', $id)->delete();
        Session::flash('sukses', 'Data consumption berhasil dihapus');
        return redirect('/consumption');
    }
 
    public function create()
    {
        $no = Consumption::max('code');
        $number = ((int)substr($no, 9));
        $number += 1;

        $year = date('Y');
        $nomor = "RKK/" . $year . "/";
        $number = $nomor . sprintf("%05s", $number);

        $id                     = Requests::input('id');
        $code                   = $number;
        $code_quotation         = Requests::input('code_quotation');
        $customer               = Requests::input('customer');
        $customer_style         = strtoupper(Requests::input('customer_style'));
        $number_mp              = Requests::input('number_mp');
        $size_tengah            = strtoupper(Requests::input('size_tengah'));
        $delivery_date          = Requests::input('delivery_date');
        $references_date        = Requests::input('references_date');
        $net_price              = Requests::input('net_price');
        $status                 = strtoupper('pending');

        Consumption::create([
            'code'              =>  $code,
            'code_quotation'    =>  $code_quotation,
            'customer'          =>  $customer,
            'customer_style'    =>  $customer_style,
            'number_mp'         =>  $number_mp,
            'size_tengah'       =>  $size_tengah,
            'delivery_date'     =>  $delivery_date,
            'references_date'   =>  $references_date,
            'net_price'         =>  $net_price,
            'status'            =>  $status
        ]);

        Session::flash('sukses', 'Data Consumption Berhasil Di simpan');
        return redirect('/consumption');
    }

    public function edit($id)
    {
        $result = Consumption::where('id', $id)->first();

        return view('consumption.edit')->with(compact('result'));
    }

    public function update()
    {
        $id                     = Requests::input('id');
        $code                   = Requests::input('code');
        $code_quotation         = Requests::input('code_quotation');
        $customer               = Requests::input('customer');
        $customer_style         = strtoupper(Requests::input('customer_style'));
        $number_mp              = Requests::input('number_mp');
        $size_tengah            = strtoupper(Requests::input('size_tengah'));
        $delivery_date          = Requests::input('delivery_date');
        $references_date        = Requests::input('references_date');
        $net_price              = Requests::input('net_price');
        $status                 = Requests::input('status');


        Consumption::where('id', $id)->update([
            'code'              =>  $code,
            'code_quotation'    =>  $code_quotation,
            'customer'          =>  $customer,
            'customer_style'    =>  $customer_style,
            'number_mp'         =>  $number_mp,
            'size_tengah'       =>  $size_tengah,
            'delivery_date'     =>  $delivery_date,
            'references_date'   =>  $references_date,
            'net_price'         =>  $net_price,
            'status'            =>  $status
        ]);
        Session::flash('sukses', 'Data Consumption Berhasil Di Update');
        return redirect('/consumption');
    }

    public function update_status($id,$status)
    {
        $id                     = $id;
        $status                 = $status;
        $userid                 = Auth::user()->id;
        $current_time           = \Carbon\Carbon::now()->toDateTimeString();

        if ($status == 'REVIEWED') {
            Consumption::where('id', $id)->update([
                'status'            =>  $status,
                'reviewed_by'       =>  $userid,
                'reviewed_at'       =>  $current_time,
                'unconfirmed_by'     =>  null,
                'unconfirmed_at'     =>  null,
            ]);
        } elseif ($status == 'UNREVIEWED') {
            Consumption::where('id', $id)->update([
                'status'            =>  'PENDING',
                'reviewed_by'       =>  null,
                'reviewed_at'       =>  null,
                'unconfirmed_by'     =>  null,
                'unconfirmed_at'     =>  null,
            ]);
        } elseif ($status == 'CONFIRMED') {
            Consumption::where('id', $id)->update([
                'status'             =>  $status,
                'confirmed_by'       =>  $userid,
                'confirmed_at'       =>  $current_time,
                'unconfirmed_by'     =>  null,
                'unconfirmed_at'     =>  null,
            ]);
        } elseif ($status == 'UNCONFIRMED') {
            Consumption::where('id', $id)->update([
                'status'             =>  $status,
                'unconfirmed_by'     =>  $userid,
                'unconfirmed_at'     =>  $current_time,
                'confirmed_by'       =>  null,
                'confirmed_at'       =>  null,
                'reviewed_by'        =>  null,
                'reviewed_at'        =>  null,
            ]);
        }

        Session::flash('sukses', '<b>'.$status.'</b> Berhasil');
        return redirect('/consumption/view/'.$id);
    }

    public function view($id)
    {
        $cons = Consumption::where('id', $id)->first();
        $cons_fab = ConsumptionDetail::where('id_consumption', $id)->where('jenis','FABRIC')->get();
        $cons_collar = ConsumptionDetail::where('id_consumption', $id)->where('jenis','COLLAR')->get();
        $cons_cuff = ConsumptionDetail::where('id_consumption', $id)->where('jenis','CUFF')->get();

        $consDetail = ConsumptionDetail::where('id_consumption', $id)->get();
        $quotation = Quotation::where('code', $cons->code_quotation)->first();

        $sumamount_fab=0;

        $sumamount_collar=0;

        $sumamount_cuff=0;

        $garment_nett_price = $quotation->totalcost_handling_margin;
        $sales_fee          = $quotation->sales_fee_value;
        $total_qty          = $quotation->forecast_qty;
        $budget             = $quotation->total_fabric_value;

        if (count($consDetail) > 0) {
           foreach ($cons_fab as $cf) {
                foreach ($cf->ConsSupplier as $cfs) {
                    foreach ($cfs->FabItem as $cfi) {
                        $sumamount_fab += $cfi->amount_freight;
                    }
                }
            }

            foreach ($cons_collar as $cc) {
                foreach ($cc->ConsSupplier as $ccs) {
                    foreach ($ccs->collarcuffItem as $cci) {
                        $sumamount_collar += $cci->amount;
                    }
                }
            }

            foreach ($cons_cuff as $ccu) {
                foreach ($ccu->ConsSupplier as $ccus) {
                    foreach ($ccus->collarcuffItem as $ccui) {
                        $sumamount_collar += $ccui->amount;
                    }
                }
            }

            $total_amount       = $sumamount_fab + $sumamount_collar + $sumamount_cuff;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = ($total_amount / $nett_sales) * 100;
            $cons_per_dz            = ($total_amount / $total_qty) * 12;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        } else {
            $total_qty = 0;
            $total_amount = 0;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = 0;
            $cons_per_dz            = 0;
            $budget                 = $total_amount;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        }

        return view('consumption.view',[
                'cons'                      => $cons,
                'cons_fab'                  => $cons_fab,
                'cons_collar'               => $cons_collar,
                'cons_cuff'                 => $cons_cuff,
                'id'                        => $id,
                'total_qty'                 => $total_qty,
                'total_amount'              => $total_amount,
                'nett_sales'                => $nett_sales,
                'purchasing_percentage'     => $purchasing_percentage,
                'cons_per_dz'               => $cons_per_dz,
                'budget'                    => $budget,
                'budget_status'             => $budget_status
            ]);
    } 

    public function add_detail()
    {
        $id_consumption         = Requests::input('id_consumption');
        $jenis                  = Requests::input('jenis');
        $id_fab_cons            = Requests::input('id_fabric_construct');
        $id_fab_comp            = Requests::input('id_fabric_compost');
        $description            = Requests::input('description');

        ConsumptionDetail::create([
            'id_consumption'    =>  $id_consumption,
            'jenis'             =>  $jenis,
            'id_fab_cons'       =>  $id_fab_cons,
            'id_fab_comp'       =>  $id_fab_comp,
            'description'       =>  $description,
        ]);

        Session::flash('sukses', $jenis.' Consumption Berhasil Di simpan');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function delete_detail($id_detail,$id_consumption)
    {       
        $getIDSup = ConsumptionDetailSupplier::where('id_detail', $id_detail)->get();
        foreach ($getIDSup as $idsup) {
            ConsumptionDetailFabricItem::where('id_cons_sup', $idsup->id)->delete();
            $getIDCollarCuff = ConsumptionDetailCollarCuffItem::where('id_cons_sup', $idsup->id)->get();
            foreach ($getIDCollarCuff as $idCollarCuff) {
                ConsumptionDetailCollarCuffItemSize::where('id_collar_cuff', $idCollarCuff->id)->delete();
            }
            ConsumptionDetailCollarCuffItem::where('id_cons_sup', $idsup->id)->delete();
        }
        ConsumptionDetailSupplier::where('id_detail', $id_detail)->delete();
        ConsumptionDetail::where('id', $id_detail)->delete();
        Session::flash('sukses', 'Data consumption berhasil dihapus');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function edit_detail_form(Request $request) {
      $cons_detail = ConsumptionDetail::where('id','=',$request->id)->first();
          if($cons_detail)
          {
            return \Response::json(\View::make('consumption.edit_detail', array('cons_detail' => $cons_detail))->render());
          } 
    }

    public function update_detail()
    {
        $id_consumption         = Requests::input('id_consumption');
        $jenis                  = Requests::input('jenis');
        $id_detail              = Requests::input('id_detail');
        $id_fab_cons            = Requests::input('id_fabric_construct');
        $id_fab_comp            = Requests::input('id_fabric_compost');
        $description            = Requests::input('description');

        ConsumptionDetail::where('id', $id_detail)->update([
            'id_fab_cons'       =>  $id_fab_cons,
            'id_fab_comp'       =>  $id_fab_comp,
            'description'       =>  $description,
        ]);

        Session::flash('sukses', $jenis.' Consumption Berhasil Di update');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function add_fabric_item()
    {
        $id_detail          = Requests::input('supplier_id_detail');
        $consdet            = ConsumptionDetail::where('id',$id_detail)->first();
        $id_consumption     = $consdet->id_consumption;
        $supplier_code      = Requests::input('supplier_code');
        $c                  = count(Requests::input('id_color'));

        $cons_supplier                  = new ConsumptionDetailSupplier;
        $cons_supplier->id_detail       = $id_detail;
        $cons_supplier->supplier_code   = $supplier_code;
        $cons_supplier->save();

        $id_color           = Requests::input('id_color');
        $total_qty          = Requests::input('total_qty');
        $komponen           = Requests::input('komponen');
        $width              = Requests::input('width');
        $w_unit             = Requests::input('w_unit');
        $kons_budget        = Requests::input('kons_budget');
        $kons_marker        = Requests::input('kons_marker');
        $kons_efi           = Requests::input('kons_efi');
        $qty_unit           = Requests::input('qty_unit');
        $tole               = Requests::input('tole');
        $qty_unit_tole      = Requests::input('qty_unit_tole');
        $qty_sample         = Requests::input('qty_sample');
        $qty_purch          = Requests::input('qty_purch');
        $budget_price       = Requests::input('budget_price');
        $supplier_price     = Requests::input('supplier_price');
        $amount             = Requests::input('amount');
        $freight            = Requests::input('freight');
        $amount_freight     = Requests::input('amount_freight');
        $unit               = Requests::input('unit');

        for ($i = 0; $i < $c; ++$i) {
            $cons_fab_item                     = new ConsumptionDetailFabricItem;
            $cons_fab_item->id_cons_sup        = $cons_supplier->id;
            $cons_fab_item->id_color           = $id_color[$i];
            $cons_fab_item->total_qty          = $total_qty[$i];
            $cons_fab_item->komponen           = $komponen[$i];
            $cons_fab_item->width              = $width[$i];
            $cons_fab_item->w_unit             = $w_unit[$i];
            $cons_fab_item->kons_budget        = $kons_budget[$i];
            $cons_fab_item->kons_marker        = $kons_marker[$i];
            $cons_fab_item->kons_efi           = $kons_efi[$i];
            $cons_fab_item->qty_unit           = $qty_unit[$i];
            $cons_fab_item->tole               = $tole[$i];
            $cons_fab_item->qty_unit_tole      = $qty_unit_tole[$i];
            $cons_fab_item->qty_sample         = $qty_sample[$i];
            $cons_fab_item->qty_purch          = $qty_purch[$i];
            $cons_fab_item->budget_price       = $budget_price[$i];
            $cons_fab_item->supplier_price     = $supplier_price[$i];
            $cons_fab_item->amount             = $amount[$i];
            $cons_fab_item->freight            = $freight[$i];
            $cons_fab_item->amount_freight     = $amount_freight[$i];
            $cons_fab_item->unit               = $unit[$i];
            $cons_fab_item->save();
        }

        Session::flash('sukses', 'Consumption Fabric Item Berhasil Di simpan');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function add_supplier_collar_cuff()
    {
        $id_detail          = Requests::input('supplier_id_detail');
        $consdet            = ConsumptionDetail::where('id',$id_detail)->first();
        $id_consumption     = $consdet->id_consumption;
        $supplier_code      = Requests::input('supplier_code');

        $cons_supplier                  = new ConsumptionDetailSupplier;
        $cons_supplier->id_detail       = $id_detail;
        $cons_supplier->supplier_code   = $supplier_code;
        $cons_supplier->save();

        Session::flash('sukses', 'Consumption Supplier Berhasil Di simpan');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function editDetailSupplierForm(Request $request) {
      $data = ConsumptionDetailSupplier::where('id','=',$request->id)->first();
      $fabItem = ConsumptionDetailFabricItem::where('id_cons_sup',$request->id)->get();
      $action_name = $request->action_name;
          if($data)
          {
            return \Response::json(\View::make('consumption.edit_supplier', array('data' => $data,'fabItem' => $fabItem,'action_name' => $action_name))->render());
          } 
    }

    public function update_fabricItem()
    {
        $id_detail          = Requests::input('id_detail');
        $id                 = Requests::input('id_cons_supplier');
        $consdet            = ConsumptionDetail::where('id',$id_detail)->first();
        $id_consumption     = $consdet->id_consumption;
        $supplier_code      = Requests::input('supplier_code');
        $c                  = count(Requests::input('id_color'));

        $cons_supplier                  = ConsumptionDetailSupplier::find($id);
        $cons_supplier->id_detail       = $id_detail;
        $cons_supplier->supplier_code   = $supplier_code;
        $cons_supplier->save();

        ConsumptionDetailFabricItem::where('id_cons_sup',$id)->delete();

        $id_color           = Requests::input('id_color');
        $total_qty          = Requests::input('total_qty');
        $komponen           = Requests::input('komponen');
        $width              = Requests::input('width');
        $w_unit             = Requests::input('w_unit');
        $kons_budget        = Requests::input('kons_budget');
        $kons_marker        = Requests::input('kons_marker');
        $kons_efi           = Requests::input('kons_efi');
        $qty_unit           = Requests::input('qty_unit');
        $tole               = Requests::input('tole');
        $qty_unit_tole      = Requests::input('qty_unit_tole');
        $qty_sample         = Requests::input('qty_sample');
        $qty_purch          = Requests::input('qty_purch');
        $budget_price       = Requests::input('budget_price');
        $supplier_price     = Requests::input('supplier_price');
        $amount             = Requests::input('amount');
        $freight            = Requests::input('freight');
        $amount_freight     = Requests::input('amount_freight');
        $unit               = Requests::input('unit');

        for ($i = 0; $i < $c; ++$i) {
            $cons_fab_item                     = new ConsumptionDetailFabricItem;
            $cons_fab_item->id_cons_sup        = $id;
            $cons_fab_item->id_color           = $id_color[$i];
            $cons_fab_item->total_qty          = $total_qty[$i];
            $cons_fab_item->komponen           = $komponen[$i];
            $cons_fab_item->width              = $width[$i];
            $cons_fab_item->w_unit             = $w_unit[$i];
            $cons_fab_item->kons_budget        = $kons_budget[$i];
            $cons_fab_item->kons_marker        = $kons_marker[$i];
            $cons_fab_item->kons_efi           = $kons_efi[$i];
            $cons_fab_item->qty_unit           = $qty_unit[$i];
            $cons_fab_item->tole               = $tole[$i];
            $cons_fab_item->qty_unit_tole      = $qty_unit_tole[$i];
            $cons_fab_item->qty_sample         = $qty_sample[$i];
            $cons_fab_item->qty_purch          = $qty_purch[$i];
            $cons_fab_item->budget_price       = $budget_price[$i];
            $cons_fab_item->supplier_price     = $supplier_price[$i];
            $cons_fab_item->amount             = $amount[$i];
            $cons_fab_item->freight            = $freight[$i];
            $cons_fab_item->amount_freight     = $amount_freight[$i];
            $cons_fab_item->unit               = $unit[$i];
            $cons_fab_item->save();
        }

        Session::flash('sukses', 'Consumption Fabric Item Berhasil Di Update');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function delete_supplier($id,$id_consumption)
    {
        $getIDCollarCuff = ConsumptionDetailCollarCuffItem::where('id_cons_sup', $id)->get();
        foreach ($getIDCollarCuff as $idCollarCuff) {
            ConsumptionDetailCollarCuffItemSize::where('id_collar_cuff', $idCollarCuff->id)->delete();
        }
        ConsumptionDetailCollarCuffItem::where('id_cons_sup', $id)->delete();
        ConsumptionDetailFabricItem::where('id_cons_sup', $id)->delete();
        ConsumptionDetailSupplier::where('id', $id)->delete();
        Session::flash('sukses', 'Data consumption berhasil dihapus');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function newcollarcuffItemForm(Request $request) {
      $idsup = $request->id;
      $action_name = $request->action_name;
          if($idsup)
          {
            return \Response::json(\View::make('consumption.new_item_collarcuff', array('idsup' => $idsup,'action_name' => $action_name))->render());
          } 
    }

    public function add_collar_cuff_item()
    {
        $id_cons_sup        = Requests::input('id_cons_sup');
        $id_consumption     = Requests::input('id_consumption');
        $unit               = Requests::input('unit');
        $id_color           = Requests::input('id_color');
        $total_qty          = Requests::input('total_qty');
        $qty_unit           = Requests::input('qty_unit');
        $budget_price       = Requests::input('budget_price');
        $total_qty_unit_pcs = Requests::input('total_qty_unit_pcs');
        $supplier_price     = Requests::input('supplier_price');
        $total_qty_unit     = Requests::input('total_qty_unit');
        $amount             = Requests::input('amount');
        $tole               = Requests::input('tole');
        $freight            = Requests::input('freight');
        $amount_freight     = Requests::input('amount_freight');
        $c                  = count(Requests::input('id_size'));

        $cons_collarcuff                        = new ConsumptionDetailCollarCuffItem;
        $cons_collarcuff->id_cons_sup           = $id_cons_sup;
        $cons_collarcuff->unit                  = $unit;
        $cons_collarcuff->id_color              = $id_color;
        $cons_collarcuff->total_qty             = $total_qty;
        $cons_collarcuff->tole                  = $tole;
        $cons_collarcuff->qty_unit              = $qty_unit;
        $cons_collarcuff->total_qty_unit_pcs    = $total_qty_unit_pcs;
        $cons_collarcuff->total_qty_unit        = $total_qty_unit;
        $cons_collarcuff->freight               = $freight;
        $cons_collarcuff->budget_price          = $budget_price;
        $cons_collarcuff->supplier_price        = $supplier_price;
        $cons_collarcuff->amount                = $amount;
        $cons_collarcuff->amount_freight        = $amount_freight;
        $cons_collarcuff->save();

        $dimension          = Requests::input('dimension');
        $id_size            = Requests::input('id_size');
        $total              = Requests::input('total');
        $total_tole         = Requests::input('total_tole');
        $total_rounded      = Requests::input('total_rounded');
        for ($i = 0; $i < $c; ++$i) {
            $cons_collarcuff_sizerange                     = new ConsumptionDetailCollarCuffItemSize;
            $cons_collarcuff_sizerange->id_collar_cuff     = $cons_collarcuff->id;
            $cons_collarcuff_sizerange->dimension          = $dimension[$i];
            $cons_collarcuff_sizerange->id_size            = $id_size[$i];
            $cons_collarcuff_sizerange->total              = $total[$i];
            $cons_collarcuff_sizerange->total_tole         = $total_tole[$i];
            $cons_collarcuff_sizerange->total_rounded      = $total_rounded[$i];
            $cons_collarcuff_sizerange->save();
        }

        Session::flash('sukses', 'Consumption Item Berhasil Di simpan');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function editcollarcuffItemForm(Request $request) {
      $action_name = $request->action_name;
      $collarcuffitem = ConsumptionDetailCollarCuffItem::where('id',$request->id)->first();
      $itemsizerange = ConsumptionDetailCollarCuffItemSize::where('id_collar_cuff',$request->id)->get();
          if($collarcuffitem)
          {
            return \Response::json(\View::make('consumption.edit_item_collarcuff', array('collarcuffitem' => $collarcuffitem,'itemsizerange' => $itemsizerange,'action_name' => $action_name))->render());
          } 
    }

    public function update_collar_cuff_item()
    {
        $id                 = Requests::input('id_collar_cuff');
        $id_cons_sup        = Requests::input('id_cons_sup');
        $id_consumption     = Requests::input('id_consumption');
        $unit               = Requests::input('unit');
        $id_color           = Requests::input('id_color');
        $total_qty          = Requests::input('total_qty');
        $qty_unit           = Requests::input('qty_unit');
        $budget_price       = Requests::input('budget_price');
        $total_qty_unit_pcs = Requests::input('total_qty_unit_pcs');
        $supplier_price     = Requests::input('supplier_price');
        $total_qty_unit     = Requests::input('total_qty_unit');
        $amount             = Requests::input('amount');
        $tole               = Requests::input('tole');
        $freight            = Requests::input('freight');
        $amount_freight     = Requests::input('amount_freight');
        $c                  = count(Requests::input('id_size'));

        $cons_collarcuff                        = ConsumptionDetailCollarCuffItem::find($id);
        $cons_collarcuff->id_cons_sup           = $id_cons_sup;
        $cons_collarcuff->unit                  = $unit;
        $cons_collarcuff->id_color              = $id_color;
        $cons_collarcuff->total_qty             = $total_qty;
        $cons_collarcuff->tole                  = $tole;
        $cons_collarcuff->qty_unit              = $qty_unit;
        $cons_collarcuff->total_qty_unit_pcs    = $total_qty_unit_pcs;
        $cons_collarcuff->total_qty_unit        = $total_qty_unit;
        $cons_collarcuff->freight               = $freight;
        $cons_collarcuff->budget_price          = $budget_price;
        $cons_collarcuff->supplier_price        = $supplier_price;
        $cons_collarcuff->amount                = $amount;
        $cons_collarcuff->amount_freight        = $amount_freight;
        $cons_collarcuff->save();

        $dimension          = Requests::input('dimension');
        $id_size            = Requests::input('id_size');
        $total              = Requests::input('total');
        $total_tole         = Requests::input('total_tole');
        $total_rounded      = Requests::input('total_rounded');

        ConsumptionDetailCollarCuffItemSize::where('id_collar_cuff',$id)->delete();

        for ($i = 0; $i < $c; ++$i) {
            $cons_collarcuff_sizerange                      = new ConsumptionDetailCollarCuffItemSize;
            $cons_collarcuff_sizerange->id_collar_cuff      = $id;
            $cons_collarcuff_sizerange->dimension           = $dimension[$i];
            $cons_collarcuff_sizerange->id_size             = $id_size[$i];
            $cons_collarcuff_sizerange->total               = $total[$i];
            $cons_collarcuff_sizerange->total_tole          = $total_tole[$i];
            $cons_collarcuff_sizerange->total_rounded       = $total_rounded[$i];
            $cons_collarcuff_sizerange->save();
        }

        Session::flash('sukses', 'Consumption Item Berhasil Di Update');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function delete_collar_cuff_item($id,$id_consumption)
    {
        ConsumptionDetailCollarCuffItemSize::where('id_collar_cuff', $id)->delete();
        ConsumptionDetailCollarCuffItem::where('id', $id)->delete();
        Session::flash('sukses', 'Data consumption berhasil dihapus');
        return redirect('/consumption/view/'.$id_consumption);
    }

    public function print_consumption($id)
    {

        $cons = Consumption::where('id', $id)->first();
        $cons_fab = ConsumptionDetail::where('id_consumption', $id)->where('jenis','FABRIC')->get();
        $cons_collar = ConsumptionDetail::where('id_consumption', $id)->where('jenis','COLLAR')->get();
        $cons_cuff = ConsumptionDetail::where('id_consumption', $id)->where('jenis','CUFF')->get();

        $consDetail = ConsumptionDetail::where('id_consumption', $id)->get();
        $quotation = Quotation::where('code', $cons->code_quotation)->first();

        //grandtotal
        $gr_total_qty_fab = 0;
        $gr_kons_marker_fab =0;
        $gr_qty_kg_fab = 0;
        $gr_qty_kg_tole_fab = 0;
        $gr_qty_po_fab = 0;
        $gr_harga_sup_fab = 0;
        $gr_amount_fab = 0;
        $gr_amount_freight_fab = 0;

        $gr_total_qty_collar = 0;
        $gr_total_qty_unit_collar = 0;
        $gr_supplier_price_collar = 0;
        $gr_amount_collar = 0;
        $gr_amount_freight_collar = 0;

        $gr_total_qty_cuff = 0;
        $gr_total_qty_unit_cuff = 0;
        $gr_supplier_price_cuff = 0;
        $gr_amount_cuff = 0;
        $gr_amount_freight_cuff = 0;
        //grandtotal

        $sumamount_fab=0;
        $sumtotal_qty_fab=0;

        $sumamount_collar=0;

        $sumamount_cuff=0;

        $total_qty_fab      = 0;
        
        $grandtotal_fab = [
            'total_qty'         => $gr_total_qty_fab,
            'kons_marker'       => $gr_kons_marker_fab,
            'qty_kg'            => $gr_qty_kg_fab,
            'qty_kg_tole'       => $gr_qty_kg_tole_fab,
            'qty_po'            => $gr_qty_po_fab,
            'harga_sup'         => $gr_harga_sup_fab,
            'amount'            => $gr_amount_fab,
            'amount_freight'    => $gr_amount_freight_fab,
        ];

        $grandtotal_collar = [
            'total_qty'         => $gr_total_qty_collar,
            'total_qty_unit'    => $gr_total_qty_unit_collar,
            'supplier_price'    => $gr_supplier_price_collar,
            'amount'            => $gr_amount_collar,
            'amount_freight'    => $gr_amount_freight_collar,
        ];

        $grandtotal_cuff = [
            'total_qty'         => $gr_total_qty_cuff,
            'total_qty_unit'    => $gr_total_qty_unit_cuff,
            'supplier_price'    => $gr_supplier_price_cuff,
            'amount'            => $gr_amount_cuff,
            'amount_freight'    => $gr_amount_freight_cuff,
        ];

        $garment_nett_price = $quotation->totalcost_handling_margin;
        $sales_fee          = $quotation->sales_fee_value;
        $total_qty          = $quotation->forecast_qty;
        $budget             = $quotation->total_fabric_value;

        if (count($consDetail) > 0) {
           foreach ($cons_fab as $cf) {
                foreach ($cf->ConsSupplier as $cfs) {
                    foreach ($cfs->FabItem as $cfi) {
                        $sumamount_fab += $cfi->amount_freight;
                        $sumtotal_qty_fab += $cfi->total_qty;
                        //grandtotal
                        $gr_total_qty_fab += $cfi->total_qty;
                        $gr_kons_marker_fab += $cfi->kons_marker;
                        $gr_qty_kg_fab += $cfi->qty_unit;
                        $gr_qty_kg_tole_fab += $cfi->qty_unit_tole;
                        $gr_qty_po_fab += $cfi->qty_purch;
                        $gr_harga_sup_fab += $cfi->supplier_price;
                        $gr_amount_fab += $cfi->amount;
                        $gr_amount_freight_fab += $cfi->amount_freight;
                        //grandtotal
                    }
                }
            }

            foreach ($cons_collar as $cc) {
                foreach ($cc->ConsSupplier as $ccs) {
                    foreach ($ccs->collarcuffItem as $cci) {
                        $sumamount_collar += $cci->amount;
                        //grandtotal
                        $gr_total_qty_collar += $cci->total_qty;
                        $gr_total_qty_unit_collar += $cci->total_qty_unit;
                        $gr_supplier_price_collar += $cci->supplier_price;
                        $gr_amount_collar += $cci->amount;
                        $gr_amount_freight_collar += $cci->amount_freight;
                        //grandtotal
                    }
                }
            }

            foreach ($cons_cuff as $ccu) {
                foreach ($ccu->ConsSupplier as $ccus) {
                    foreach ($ccus->collarcuffItem as $ccui) {
                        $sumamount_collar += $ccui->amount;
                        //grandtotal
                        $gr_total_qty_cuff += $ccus->total_qty;
                        $gr_total_qty_unit_cuff += $ccus->total_qty_unit;
                        $gr_supplier_price_cuff += $ccus->supplier_price;
                        $gr_amount_cuff += $ccus->amount;
                        $gr_amount_freight_cuff += $ccus->amount_freight;
                        //grandtotal
                    }
                }
            }

            $grandtotal_fab = [
                'total_qty'         => $gr_total_qty_fab,
                'kons_marker'       => $gr_kons_marker_fab,
                'qty_kg'            => $gr_qty_kg_fab,
                'qty_kg_tole'       => $gr_qty_kg_tole_fab,
                'qty_po'            => $gr_qty_po_fab,
                'harga_sup'         => $gr_harga_sup_fab,
                'amount'            => $gr_amount_fab,
                'amount_freight'    => $gr_amount_freight_fab,
            ];

            $grandtotal_collar = [
                'total_qty'         => $gr_total_qty_collar,
                'total_qty_unit'    => $gr_total_qty_unit_collar,
                'supplier_price'    => $gr_supplier_price_collar,
                'amount'            => $gr_amount_collar,
                'amount_freight'    => $gr_amount_freight_collar,
            ];

            $grandtotal_cuff = [
                'total_qty'         => $gr_total_qty_cuff,
                'total_qty_unit'    => $gr_total_qty_unit_cuff,
                'supplier_price'    => $gr_supplier_price_cuff,
                'amount'            => $gr_amount_cuff,
                'amount_freight'    => $gr_amount_freight_cuff,
            ];

            $total_qty_fab      = $sumtotal_qty_fab;
            $total_amount       = $sumamount_fab + $sumamount_collar + $sumamount_cuff;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = ($total_amount / $nett_sales) * 100;
            $cons_per_dz            = ($total_amount / $total_qty) * 12;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        } else {
            $total_qty = 0;
            $total_amount = 0;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = 0;
            $cons_per_dz            = 0;
            $budget                 = $total_amount;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        }

        return view('consumption.print_consumption',[
                'cons'                      => $cons,
                'cons_fab'                  => $cons_fab,
                'cons_collar'               => $cons_collar,
                'cons_cuff'                 => $cons_cuff,
                'id'                        => $id,
                'total_qty'                 => $total_qty,
                'total_qty_fab'             => $total_qty_fab,
                'total_amount'              => $total_amount,
                'nett_sales'                => $nett_sales,
                'purchasing_percentage'     => $purchasing_percentage,
                'cons_per_dz'               => $cons_per_dz,
                'budget'                    => $budget,
                'budget_status'             => $budget_status,
                'grandtotal_fab'            => $grandtotal_fab,
                'grandtotal_collar'         => $grandtotal_collar,
                'grandtotal_cuff'           => $grandtotal_cuff,
            ]);
    }

    public function print_purchase_request($id)
    {

        $cons = Consumption::where('id', $id)->first();
        $cons_fab = ConsumptionDetail::where('id_consumption', $id)->where('jenis','FABRIC')->get();
        $cons_collar = ConsumptionDetail::where('id_consumption', $id)->where('jenis','COLLAR')->get();
        $cons_cuff = ConsumptionDetail::where('id_consumption', $id)->where('jenis','CUFF')->get();

        $consDetail = ConsumptionDetail::where('id_consumption', $id)->get();
        $quotation = Quotation::where('code', $cons->code_quotation)->first();

        //grandtotal
        $gr_total_qty_fab = 0;
        $gr_kons_marker_fab =0;
        $gr_qty_kg_fab = 0;
        $gr_qty_kg_tole_fab = 0;
        $gr_qty_po_fab = 0;
        $gr_harga_sup_fab = 0;
        $gr_amount_fab = 0;
        $gr_amount_freight_fab = 0;

        $gr_total_qty_collar = 0;
        $gr_total_qty_unit_collar = 0;
        $gr_supplier_price_collar = 0;
        $gr_amount_collar = 0;
        $gr_amount_freight_collar = 0;

        $gr_total_qty_cuff = 0;
        $gr_total_qty_unit_cuff = 0;
        $gr_supplier_price_cuff = 0;
        $gr_amount_cuff = 0;
        $gr_amount_freight_cuff = 0;
        //grandtotal

        $sumamount_fab=0;
        $sumtotal_qty_fab=0;

        $sumamount_collar=0;

        $sumamount_cuff=0;

        $total_qty_fab      = 0;
        
        $grandtotal_fab = [
            'total_qty'         => $gr_total_qty_fab,
            'kons_marker'       => $gr_kons_marker_fab,
            'qty_kg'            => $gr_qty_kg_fab,
            'qty_kg_tole'       => $gr_qty_kg_tole_fab,
            'qty_po'            => $gr_qty_po_fab,
            'harga_sup'         => $gr_harga_sup_fab,
            'amount'            => $gr_amount_fab,
            'amount_freight'    => $gr_amount_freight_fab,
        ];

        $grandtotal_collar = [
            'total_qty'         => $gr_total_qty_collar,
            'total_qty_unit'    => $gr_total_qty_unit_collar,
            'supplier_price'    => $gr_supplier_price_collar,
            'amount'            => $gr_amount_collar,
            'amount_freight'    => $gr_amount_freight_collar,
        ];

        $grandtotal_cuff = [
            'total_qty'         => $gr_total_qty_cuff,
            'total_qty_unit'    => $gr_total_qty_unit_cuff,
            'supplier_price'    => $gr_supplier_price_cuff,
            'amount'            => $gr_amount_cuff,
            'amount_freight'    => $gr_amount_freight_cuff,
        ];


        $garment_nett_price = $quotation->totalcost_handling_margin;
        $sales_fee          = $quotation->sales_fee_value;
        $total_qty          = $quotation->forecast_qty;
        $budget             = $quotation->total_fabric_value;

        if (count($consDetail) > 0) {
           foreach ($cons_fab as $cf) {
                foreach ($cf->ConsSupplier as $cfs) {
                    foreach ($cfs->FabItem as $cfi) {
                        $sumamount_fab += $cfi->amount_freight;
                        $sumtotal_qty_fab += $cfi->total_qty;
                        //grandtotal
                        $gr_total_qty_fab += $cfi->total_qty;
                        $gr_kons_marker_fab += $cfi->kons_marker;
                        $gr_qty_kg_fab += $cfi->qty_unit;
                        $gr_qty_kg_tole_fab += $cfi->qty_unit_tole;
                        $gr_qty_po_fab += $cfi->qty_purch;
                        $gr_harga_sup_fab += $cfi->supplier_price;
                        $gr_amount_fab += $cfi->amount;
                        $gr_amount_freight_fab += $cfi->amount_freight;
                        //grandtotal
                    }
                }
            }

            foreach ($cons_collar as $cc) {
                foreach ($cc->ConsSupplier as $ccs) {
                    foreach ($ccs->collarcuffItem as $cci) {
                        $sumamount_collar += $cci->amount;
                        //grandtotal
                        $gr_total_qty_collar += $cci->total_qty;
                        $gr_total_qty_unit_collar += $cci->total_qty_unit;
                        $gr_supplier_price_collar += $cci->supplier_price;
                        $gr_amount_collar += $cci->amount;
                        $gr_amount_freight_collar += $cci->amount_freight;
                        //grandtotal
                    }
                }
            }

            foreach ($cons_cuff as $ccu) {
                foreach ($ccu->ConsSupplier as $ccus) {
                    foreach ($ccus->collarcuffItem as $ccui) {
                        $sumamount_collar += $ccui->amount;
                        //grandtotal
                        $gr_total_qty_cuff += $ccus->total_qty;
                        $gr_total_qty_unit_cuff += $ccus->total_qty_unit;
                        $gr_supplier_price_cuff += $ccus->supplier_price;
                        $gr_amount_cuff += $ccus->amount;
                        $gr_amount_freight_cuff += $ccus->amount_freight;
                        //grandtotal
                    }
                }
            }

            $grandtotal_fab = [
                'total_qty'         => $gr_total_qty_fab,
                'kons_marker'       => $gr_kons_marker_fab,
                'qty_kg'            => $gr_qty_kg_fab,
                'qty_kg_tole'       => $gr_qty_kg_tole_fab,
                'qty_po'            => $gr_qty_po_fab,
                'harga_sup'         => $gr_harga_sup_fab,
                'amount'            => $gr_amount_fab,
                'amount_freight'    => $gr_amount_freight_fab,
            ];

            $grandtotal_collar = [
                'total_qty'         => $gr_total_qty_collar,
                'total_qty_unit'    => $gr_total_qty_unit_collar,
                'supplier_price'    => $gr_supplier_price_collar,
                'amount'            => $gr_amount_collar,
                'amount_freight'    => $gr_amount_freight_collar,
            ];

            $grandtotal_cuff = [
                'total_qty'         => $gr_total_qty_cuff,
                'total_qty_unit'    => $gr_total_qty_unit_cuff,
                'supplier_price'    => $gr_supplier_price_cuff,
                'amount'            => $gr_amount_cuff,
                'amount_freight'    => $gr_amount_freight_cuff,
            ];

            $total_qty_fab      = $sumtotal_qty_fab;
            $total_amount       = $sumamount_fab + $sumamount_collar + $sumamount_cuff;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = ($total_amount / $nett_sales) * 100;
            $cons_per_dz            = ($total_amount / $total_qty) * 12;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        } else {
            $total_qty = 0;
            $total_amount = 0;

            $nett_sales             = ($total_qty * $garment_nett_price) - $sales_fee;
            $purchasing_percentage  = 0;
            $cons_per_dz            = 0;
            $budget                 = $total_amount;

            $budget_status          = "not_available";
            if ($cons_per_dz > $budget) {
                $budget_status = "OVER BUDGET";
            } else {
                $budget_status = "AMAN";
            }
        }

        return view('consumption.print_purchase_request',[
                'cons'                      => $cons,
                'cons_fab'                  => $cons_fab,
                'cons_collar'               => $cons_collar,
                'cons_cuff'                 => $cons_cuff,
                'id'                        => $id,
                'total_qty'                 => $total_qty,
                'total_qty_fab'             => $total_qty_fab,
                'total_amount'              => $total_amount,
                'nett_sales'                => $nett_sales,
                'purchasing_percentage'     => $purchasing_percentage,
                'cons_per_dz'               => $cons_per_dz,
                'budget'                    => $budget,
                'budget_status'             => $budget_status,
                'grandtotal_fab'            => $grandtotal_fab,
                'grandtotal_collar'         => $grandtotal_collar,
                'grandtotal_cuff'           => $grandtotal_cuff,
            ]);
    }

}
