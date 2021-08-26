@extends('layouts.app')

@section('content')

<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/consumption')}}">Consumption</a></li>
        <li class="breadcrumb-item active">{{$cons->code}}</li>
    </ol>

    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $sukses; ?>
    </div>
    @endif
    @if ($error = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $error; ?>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            Detail Consumption
        </div>
        <div class="card-body text-size-small">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Number</b></div>
                    <div class="col-sm-8">: {{$cons->code}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Garment Net Price</b></div>
                    <div class="col-sm-8">: {{number_format($cons->quotation['totalcost_handling_margin'],2)}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Marker Production</b></div>
                    <div class="col-sm-8">: {{$cons->number_mp}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Sales Order Number</b></div>
                    <div class="col-sm-8">: {{$cons->salesorder->number}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Net Sales</b></div>
                    <div class="col-sm-8">: {{number_format($nett_sales,2)}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Size Tengah</b></div>
                    <div class="col-sm-8">: {{$cons->size_tengah}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Customer</b></div>
                    <div class="col-sm-8">: {{$cons->customer}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>% PO</b></div>
                    <div class="col-sm-8">: {{number_format($purchasing_percentage,2)}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>state</b></div>
                    <div class="col-sm-8">: {{$cons->status}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Style</b></div>
                    <div class="col-sm-8">: {{$cons->styles['name']}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Consumption Per Dz</b></div>
                    <div class="col-sm-8">: {{number_format($cons_per_dz,2)}}</div>
                </div>
                @if ($cons->status == 'REVIEWED')
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Reviewed By</b></div>
                    <div class="col-sm-8">: {{$cons->reviewedBy['name']}} @if($cons->reviewed_by)
                        ({{date('d-m-Y H:i:s', strtotime($cons->reviewed_at))}}) @endif</div>
                </div>
                @elseif ($cons->status == 'CONFIRMED')
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Confirmed By</b></div>
                    <div class="col-sm-8">: {{$cons->confirmedBy['name']}} @if($cons->confirmed_by)
                        ({{date('d-m-Y H:i:s', strtotime($cons->confirmed_at))}}) @endif</div>
                </div>
                @else
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>-</b></div>
                    <div class="col-sm-8">: -</div>
                </div>
                @endif
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Quotation</b></div>
                    <div class="col-sm-8">: {{$cons->code_quotation}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Budget</b></div>
                    <div class="col-sm-8">: {{number_format($budget,2)}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Created By</b></div>
                    <div class="col-sm-8">: {{$cons->createdBy['name']}} @if($cons->created_by)
                        ({{date('d-m-Y H:i:s', strtotime($cons->created_at))}}) @endif</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Delivery Date</b></div>
                    <div class="col-sm-8">: {{date('d-m-Y', strtotime($cons->delivery_date))}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Budget Status</b></div>
                    <div class="col-sm-8">: <i class="@if($budget_status=='AMAN') btn-success @else btn-danger @endif">
                            &nbsp {{$budget_status}} &nbsp </i></div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Updated By</b></div>
                    <div class="col-sm-8">: {{$cons->updatedBy['name']}} @if($cons->updated_by)
                        ({{date('d-m-Y H:i:s', strtotime($cons->updated_at))}}) @endif</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>References Date</b></div>
                    <div class="col-sm-8">: {{date('d-m-Y', strtotime($cons->references_date))}}</div>
                </div>
            </div>

            <div class="mt-3">
                <a href="/consumption" class="btn btn-secondary btn-sm">Back</a>
                @if ($cons->status == "PENDING" || $cons->status == "UNCONFIRMED" || $cons->status == "UNREVIEWED")
                <a href="/consumption/edit/{{$cons->id}}" class="btn btn-primary btn-sm">Edit</a>
                <a href="/consumption/update_status/{{$id}}/REVIEWED" class="btn btn-warning btn-sm"
                    onclick="return confirm('Anda yakin untuk Review?')">Review</a>
                @elseif ($cons->status == "REVIEWED")
                <a href="/consumption/update_status/{{$id}}/UNREVIEWED" class="btn btn-warning btn-sm"
                    onclick="return confirm('Anda yakin untuk Unreview?')">Unreview</a>
                <a href="/consumption/update_status/{{$id}}/CONFIRMED" class="btn btn-success btn-sm"
                    onclick="return confirm('Anda yakin untuk konfirmasi?')">Confirm</a>
                @elseif ($cons->status == "CONFIRMED")
                <a href="/consumption/update_status/{{$id}}/UNCONFIRMED" class="btn btn-danger btn-sm"
                    onclick="return confirm('Anda yakin untuk membatalkan konfirmasi?')">Unconfirm</a>
                @endif

                <a href="/consumption/print_consumption/{{$id}}" target="_blank" id=""
                    class="btn btn-primary btn-sm">Print</a>
                <a href="#" target="_blank" id="" class="btn btn-primary btn-sm">Purchase Request</a>
            </div>
            <br>
        </div>
    </div>
    <!-- start fabric table -->
    <div class="card mt-3">
        <div class="card-header">
            @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" || $cons->status == "UNREVIEWED")
            <a href="#" onclick="$('#jenis').val('FABRIC');$('#judul').html('NEW FABRIC CONSUMPTION');"
                data-toggle="modal" data-target="#modal_add_detail" class="btn btn-primary btn-sm">NEW FABRIC
                CONSUMPTION</a>
            @else
            <h7>FABRIC CONSUMPTION</h7>
            @endif
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_fab as $consfab)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$consfab->fabricconst['name']}} {{$consfab->fabriccomp['name']}}
                                        {{$consfab->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectForm('fabric','{{$consfab->id}}');" data-toggle="modal"
                                            data-target="#modal_new_item">New Item</a>
                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#modal_edit_detail"
                                            onclick="$('#judul_edit').html('EDIT FABRIC CONSUMPTION');ModalEditDetail('{{$consfab->id}}');">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_detail/{{$consfab->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>KOMPONEN</th>
                            <th>LEBAR</th>
                            <th>CONS BUDGET</th>
                            <th>CONS MARKER</th>
                            <th>EFISIENSI MARKER</th>
                            <th>QTY UNIT</th>
                            <th>TOL (%)</th>
                            <th>QTY UNIT + TOL</th>
                            <th>QTY SAMPLE</th>
                            <th>QTY PURCH</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                        </tr>
                    </tbody>
                    <tbody>
                        <?php
                            $sumtotal_qty_fab = 0;
                            $sumkons_marker_fab = 0;
                            $sumqty_unit_fab = 0;
                            $sumqty_unit_tole_fab = 0;
                            $sumqty_purch_fab = 0;
                            $sumsupplier_price_fab = 0;
                            $sumamount_fab = 0;
                            $sumamount_freight_fab = 0;
                        ?>
                        @foreach ($consfab->ConsSupplier as $consfabsup)
                        <tr>
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$consfabsup->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectEditForm('fabric','{{$consfabsup->id}}');"
                                            data-toggle="modal" data-target="#modal_edit_supplier">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_supplier/{{$consfabsup->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($consfabsup->FabItem as $fabitem)
                        <tr>
                            <td>{{$fabitem->fab_color['name']}}</td>
                            <td>{{number_format($fabitem->total_qty,2)}}</td>
                            <td>{{$fabitem->komponen}}</td>
                            <td>{{number_format($fabitem->width,2)}} {{$fabitem->w_unit}}</td>
                            <td>{{number_format($fabitem->kons_budget,2)}}</td>
                            <td>{{number_format($fabitem->kons_marker,2)}}</td>
                            <td>{{number_format($fabitem->kons_efi,2)}}</td>
                            <td>{{number_format($fabitem->qty_unit,2)}}</td>
                            <td>{{number_format($fabitem->tole,2)}}</td>
                            <td>{{number_format($fabitem->qty_unit_tole,2)}}</td>
                            <td>{{number_format($fabitem->qty_sample,2)}}</td>
                            <td>{{number_format($fabitem->qty_purch,2)}}</td>
                            <td>{{number_format($fabitem->budget_price,2)}}</td>
                            <td>{{number_format($fabitem->supplier_price,2)}}</td>
                            <td>{{$fabitem->unit}}</td>
                            <td>{{number_format($fabitem->amount,2)}}</td>
                            <td>{{number_format($fabitem->amount_freight,2)}}</td>
                        </tr>
                        <?php
                            $sumtotal_qty_fab += $fabitem->total_qty;
                            $sumkons_marker_fab += $fabitem->kons_marker;
                            $sumqty_unit_fab += $fabitem->qty_unit;
                            $sumqty_unit_tole_fab += $fabitem->qty_unit_tole;
                            $sumqty_purch_fab += $fabitem->qty_purch;
                            $sumsupplier_price_fab += $fabitem->supplier_price;
                            $sumamount_fab += $fabitem->amount;
                            $sumamount_freight_fab += $fabitem->amount_freight;
                        ?>
                        @endforeach
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr style="background-color: #a2b8a6; ">
                            <td><b>TOTAL</b></td>
                            <td><b>{{number_format($sumtotal_qty_fab,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{number_format($sumkons_marker_fab,2)}}</b></td>
                            <td></td>
                            <td><b>{{number_format($sumqty_unit_fab,2)}}</b></td>
                            <td></td>
                            <td><b>{{number_format($sumqty_unit_tole_fab,2)}}</b></td>
                            <td></td>
                            <td><b>{{number_format($sumqty_purch_fab,2)}}</b></td>
                            <td></td>
                            <td>{{number_format($sumsupplier_price_fab,2)}}</td>
                            </td>
                            <td></td>
                            <td><b>{{number_format($sumamount_fab,2)}}</b></td>
                            <td><b>{{number_format($sumamount_freight_fab,2)}}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end fabric table -->

    <!-- start collar table -->
    <div class="card mt-3">
        <div class="card-header">
            @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" || $cons->status == "UNREVIEWED")
            <a href="#" onclick="$('#jenis').val('COLLAR');$('#judul').html('NEW COLLAR CONSUMPTION');"
                data-toggle="modal" data-target="#modal_add_detail" class="btn btn-info btn-sm">NEW COLLAR
                CONSUMPTION</a>
            @else
            <h7>COLLAR CONSUMPTION</h7>
            @endif
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_collar as $conscollar)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$conscollar->fabricconst['name']}} {{$conscollar->fabriccomp['name']}}
                                        {{$conscollar->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectForm('collar','{{$conscollar->id}}');" data-toggle="modal"
                                            data-target="#modal_new_item">New Item</a>

                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#modal_edit_detail"
                                            onclick="$('#judul_edit').html('EDIT COLLAR CONSUMPTION');ModalEditDetail('{{$conscollar->id}}');">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_detail/{{$conscollar->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>TOL (%)</th>
                            <th>KG/PCS</th>
                            <th>TOTAL QTY UNIT</th>
                            <th>QTY UNIT</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                            <th>DIMENSION</th>
                            <th>SIZE</th>
                            <th>TOTAL</th>
                            <th>TOTAL TOLERANCE</th>
                            <th>TOTAL ROUNDED</th>
                        </tr>
                    </tbody>
                    <tbody>
                        <?php
                            $sumtotal_qty_collar = 0;
                            $sumtotal_qty_unit_collar = 0;
                            $sumsupplier_price_collar = 0;
                            $sumamount_collar = 0;
                            $sumamount_freight_collar = 0;
                        ?>
                        @foreach ($conscollar->ConsSupplier as $conscollarsup)
                        <tr>
                            <td colspan="17" bgcolor="#d6ffe8">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$conscollarsup->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#modal_collarcuff_new_item"
                                            onclick="CollarCuffGetIDsup('collar','{{$conscollarsup->id}}')">New Item</a>
                                        <a class="dropdown-item" href=""
                                            onclick="selectEditForm('collar','{{$conscollarsup->id}}');"
                                            data-toggle="modal" data-target="#modal_edit_supplier">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_supplier/{{$conscollarsup->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($conscollarsup->collarcuffItem as $collaritem)
                        <tr>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$collaritem->fab_color['name']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectCollarCuffEditForm('collar','{{$collaritem->id}}');"
                                            data-toggle="modal" data-target="#modal_edit_collar_cuff">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_collar_cuff_item/{{$collaritem->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->tole,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->qty_unit,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty_unit_pcs,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty_unit,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->budget_price,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->supplier_price,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{$collaritem->unit}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->amount,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->amount_freight,2)}}</td>
                            <td colspan="5">
                                @foreach ($collaritem->collarcuffItemSize as $itemsize)
                        <tr>
                            <td>{{$itemsize->dimension}}</td>
                            <td>{{$itemsize->itemSize['name']}}</td>
                            <td>{{number_format($itemsize->total,2)}}</td>
                            <td>{{number_format($itemsize->total_tole,2)}}</td>
                            <td>{{number_format($itemsize->total_rounded,2)}}</td>
                        </tr>
                        @endforeach
                        </td>
                        </tr>
                        <?php
                            $sumtotal_qty_collar += $collaritem->total_qty;
                            $sumtotal_qty_unit_collar += $collaritem->total_qty_unit_pcs;
                            $sumsupplier_price_collar += $collaritem->supplier_price;
                            $sumamount_collar += $collaritem->amount;
                            $sumamount_freight_collar += $collaritem->amount_freight;
                        ?>
                        @endforeach
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr style="background-color: #a2b8a6; ">
                            <td></td>
                            <td><b>{{number_format($sumtotal_qty_collar,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td><b>{{number_format($sumtotal_qty_unit_collar,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($sumsupplier_price_collar,2)}}</td>
                            </td>
                            <td></td>
                            <td><b>{{number_format($sumamount_collar,2)}}</b></td>
                            <td><b>{{number_format($sumamount_freight_collar,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end collar table -->

    <!-- start cuff table -->
    <div class="card mt-3">
        <div class="card-header">
            @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" || $cons->status == "UNREVIEWED")
            <a href="#" onclick="$('#jenis').val('CUFF');$('#judul').html('NEW CUFF CONSUMPTION');" data-toggle="modal"
                data-target="#modal_add_detail" class="btn btn-danger btn-sm">NEW CUFF CONSUMPTION</a>
            @else
            <h7>CUFF CONSUMPTION</h7>
            @endif
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_cuff as $conscuff)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$conscuff->fabricconst['name']}} {{$conscuff->fabriccomp['name']}}
                                        {{$conscuff->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectForm('cuff','{{$conscuff->id}}');" data-toggle="modal"
                                            data-target="#modal_new_item">New Item</a>

                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#modal_edit_detail"
                                            onclick="$('#judul_edit').html('EDIT CUFF CONSUMPTION');ModalEditDetail('{{$conscuff->id}}');">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_detail/{{$conscuff->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>TOL (%)</th>
                            <th>KG/PCS</th>
                            <th>TOTAL QTY UNIT</th>
                            <th>QTY UNIT</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                            <th>DIMENSION</th>
                            <th>SIZE</th>
                            <th>TOTAL</th>
                            <th>TOTAL TOLERANCE</th>
                            <th>TOTAL ROUNDED</th>
                        </tr>
                    </tbody>
                    <tbody>
                        <?php
                            $sumtotal_qty_cuff = 0;
                            $sumtotal_qty_unit_cuff = 0;
                            $sumsupplier_price_cuff = 0;
                            $sumamount_cuff = 0;
                            $sumamount_freight_cuff = 0;
                        ?>
                        @foreach ($conscuff->ConsSupplier as $conscuffsup)
                        <tr>
                            <td colspan="17" bgcolor="#d6ffe8">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$conscuffsup->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#modal_collarcuff_new_item"
                                            onclick="CollarCuffGetIDsup('cuff','{{$conscuffsup->id}}')">New Item</a>
                                        <a class="dropdown-item" href=""
                                            onclick="selectEditForm('cuff','{{$conscuffsup->id}}');" data-toggle="modal"
                                            data-target="#modal_edit_supplier">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_supplier/{{$conscuffsup->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($conscuffsup->collarcuffItem as $collaritem)
                        <tr>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$collaritem->fab_color['name']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING" ||
                                        $cons->status == "UNREVIEWED")
                                        <a class="dropdown-item" href=""
                                            onclick="selectCollarCuffEditForm('cuff','{{$collaritem->id}}');"
                                            data-toggle="modal" data-target="#modal_edit_collar_cuff">Edit</a>
                                        <a class="dropdown-item"
                                            href="/consumption/delete_collar_cuff_item/{{$collaritem->id}}/{{$id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->tole,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->qty_unit,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty_unit_pcs,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->total_qty_unit,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->budget_price,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->supplier_price,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{$collaritem->unit}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->amount,2)}}</td>
                            <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                                {{number_format($collaritem->amount_freight,2)}}</td>
                            <td colspan="5">
                                @foreach ($collaritem->collarcuffItemSize as $itemsize)
                        <tr>
                            <td>{{$itemsize->dimension}}</td>
                            <td>{{$itemsize->itemSize['name']}}</td>
                            <td>{{number_format($itemsize->total,2)}}</td>
                            <td>{{number_format($itemsize->total_tole,2)}}</td>
                            <td>{{number_format($itemsize->total_rounded,2)}}</td>
                        </tr>
                        @endforeach
                        </td>
                        </tr>
                        <?php
                            $sumtotal_qty_cuff += $collaritem->total_qty;
                            $sumtotal_qty_unit_cuff += $collaritem->total_qty_unit_pcs;
                            $sumsupplier_price_cuff += $collaritem->supplier_price;
                            $sumamount_cuff += $collaritem->amount;
                            $sumamount_freight_cuff += $collaritem->amount_freight;
                        ?>
                        @endforeach
                    </tbody>
                    @endforeach
                    <tfoot>
                        <tr style="background-color: #a2b8a6; ">
                            <td></td>
                            <td><b>{{number_format($sumtotal_qty_cuff,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td><b>{{number_format($sumtotal_qty_unit_cuff,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format($sumsupplier_price_cuff,2)}}</td>
                            </td>
                            <td></td>
                            <td><b>{{number_format($sumamount_cuff,2)}}</b></td>
                            <td><b>{{number_format($sumamount_freight_cuff,2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end cuff table -->

    <!-- modal -->

    <div class="row">
        <div id="modal_add_detail" class="modal fade">
            <div class="modal-dialog">
                <form action="/consumption/add_detail" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul"><strong>NEW </strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabric_construct">Fabric Construct</label>
                                    <input type="hidden" id="id_fabric_construct" type="text"
                                        class="form-control @error('id_fabric_construct') is-invalid @enderror"
                                        name="id_fabric_construct" value="{{ old('id_fabric_construct') }}" required
                                        autocomplete="off">
                                    <input id="fabric_construct" type="text"
                                        class="form-control @error('fabric_construct') is-invalid @enderror"
                                        name="fabric_construct" value="{{ old('fabric_construct') }}" required
                                        autocomplete="off">
                                    <span>
                                        <div id="id_fabric_constructlist"></div>
                                    </span>

                                    @error('id_fabric_construct')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabric_compost">Fabric Compost</label>
                                    <input type="hidden" id="id_fabric_compost" type="text"
                                        class="form-control @error('id_fabric_compost') is-invalid @enderror"
                                        name="id_fabric_compost" value="{{ old('id_fabric_compost') }}" required
                                        autocomplete="off">
                                    <input id="fabric_compost" type="text"
                                        class="form-control @error('fabric_compost') is-invalid @enderror"
                                        name="fabric_compost" value="{{ old('fabric_compost') }}" required
                                        autocomplete="off">
                                    <span>
                                        <div id="id_fabric_compostlist"></div>
                                    </span>

                                    @error('id_fabric_compost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabric_description">Fabric Descripstion</label>
                                    <input type="text" name="description" id="fabric_description" class="form-control"
                                        placeholder="Fabric Description">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <input type="hidden" name="id_consumption" value="{{$id}}" required>
                                <input type="hidden" name="jenis" id="jenis" value="" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_edit_detail" class="modal fade">
            <div class="modal-dialog">
                <form action="/consumption/update_detail" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul_edit"><strong>EDIT </strong></h6>
                        </div>
                        <div class="modal-body">
                            <div id="isi_edit_detail"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_new_item" class="modal fade">
            <div class="">
                <form action="/consumption/new_item" name="newItemForm" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul_new_item"><strong>New ITEM </strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="supplier">Supplier</label>
                                    <input type="hidden" id="supplier_code" type="text"
                                        class="form-control @error('supplier_code') is-invalid @enderror"
                                        name="supplier_code" required autocomplete="off">
                                    <input id="supplier" type="text"
                                        class="form-control @error('supplier') is-invalid @enderror" name="supplier"
                                        required autocomplete="off">
                                    <span>
                                        <div id="supplier_codelist"></div>
                                    </span>

                                    @error('supplier_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="supplier_id_detail" id="supplier_id_detail">
                            <div id="new_item_fabric"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_edit_supplier" class="modal fade">
            <div class="">
                <form action="" name="editItemForm" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul_edit_item"><strong>EDIT ITEM </strong></h6>
                        </div>
                        <div class="modal-body">
                            <div id="isi_edit_supplier"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_collarcuff_new_item" class="modal fade">
            <div class="modal-dialog  modal-lg">
                <form action="" name="collarcuffItemForm" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul_collarcuff_item"><strong>new ITEM </strong></h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_consumption" value="{{$id}}" required>
                            <div id="isi_collarcuff_item"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal_edit_collar_cuff" class="modal fade">
            <div class="modal-dialog  modal-lg">
                <form action="" name="collarcuffItemFormEdit" method="post">
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title" id="judul_collarcuff_item_edit"><strong>edit ITEM </strong></h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_consumption" value="{{$id}}" required>
                            <div id="isi_collarcuff_item_edit"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- end modal -->


</div>

</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
            var count = 1;

            $('#color_form').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.color_form') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#color_formlist').fadeIn();
                            $('#color_formlist').html(data);
                            } else {
                            $('#color_formlist').fadeOut();
                            $('#color_formlist').empty();
                            $('#color_form').val('');
                            }
                        }
                    });
                }
            });

            $('#fabric_construct').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabricconst') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                                $('#id_fabric_constructlist').fadeIn();
                                $('#id_fabric_constructlist').html(data);
                            } else {
                                $('#id_fabric_constructlist').fadeOut();
                                $('#id_fabric_constructlist').empty();
                                $('#id_fabric_construct').val('');
                                $('#fabric_construct').val('');
                            }
                        }
                    });
                }
            });
            $('#fabric_compost').keyup(function(){
                var query = $(this).val();
                var fabricconstruct_id = $('#id_fabric_construct').val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabriccomp') }}",
                    method:"POST",
                    data:{query:query, id_fabricconst:fabricconstruct_id, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#id_fabric_compostlist').fadeIn();
                            $('#id_fabric_compostlist').html(data);
                            } else {
                            $('#id_fabric_compostlist').fadeOut();
                            $('#id_fabric_compostlist').empty();
                            $('#id_fabric_compost').val('');
                            $('#fabric_compost').val('');
                            }
                        }
                    });
                }
            });

            $('#supplier').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.supplier') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                                $('#supplier_codelist').fadeIn();
                                $('#supplier_codelist').html(data);
                            } else {
                                $('#supplier_codelist').fadeOut();
                                $('#supplier_codelist').empty();
                                $('#supplier_code').val('');
                                $('#supplier').val('');
                            }
                        }
                    });
                }
            });


        });

        function selectForm(action_name,id_detail){
            if( action_name=="fabric" ) {
                document.newItemForm.action = "/consumption/add_detail/fabric";
                $('#judul_new_item').html('NEW FABRIC ITEM');
                $('#supplier_id_detail').val(id_detail);
                $('#new_item_fabric').load('{{URL::to("consumption/newItem_Fabric/")}}');
            }
            else if( action_name=="collar" ) {
                document.newItemForm.action = "/consumption/add_detail/add_supplier_collar_cuff";
                $('#judul_new_item').html('NEW SUPPLIER COLLAR ITEM');
                $('#supplier_id_detail').val(id_detail);
                $('#new_item_fabric').html('');
            }
            else if( action_name=="cuff" ) {
                document.newItemForm.action = "/consumption/add_detail/add_supplier_collar_cuff";
                $('#judul_new_item').html('NEW SUPPLIER CUFF ITEM');
                $('#supplier_id_detail').val(id_detail);
                $('#new_item_fabric').html('');
            }
        }

        function selectEditForm(action_name,id){
            if( action_name=="fabric" ) {
                $('#new_item_fabric').html('');
                document.editItemForm.action = "/consumption/edit_detail/update_fabricItem";
                $('#judul_edit_item').html('EDIT FABRIC ITEM');
            }
            else if( action_name=="collar" ) {
                document.editItemForm.action = "/consumption/edit_detail/update_supplier_collar_cuff";
                $('#judul_edit_item').html('EDIT SUPPLIER COLLAR ITEM');
            }
            else if( action_name=="cuff" ) {
                document.editItemForm.action = "/consumption/edit_detail/update_supplier_collar_cuff";
                $('#judul_edit_item').html('EDIT SUPPLIER CUFF ITEM');
            }

            $.ajax({
                url : '{{URL::to("consumption/editDetailSupplierForm/")}}',
                type : 'get',
                dataType: 'json',
                data:{'id':id,'action_name':action_name}
            }).done(function (data) {
                $('#isi_edit_supplier').html(data);
            }).fail(function (msg) {
                alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

        function CollarCuffGetIDsup(action_name,id){
            if( action_name=="collar" ) {
                document.collarcuffItemForm.action = "/consumption/add_detail/new_collar_cuff_item";
                $('#judul_collarcuff_item').html('NEW COLLAR ITEM');
            }
            else if( action_name=="cuff" ) {
                document.collarcuffItemForm.action = "/consumption/add_detail/new_collar_cuff_item";
                $('#judul_collarcuff_item').html('NEW CUFF ITEM');
            }

            $.ajax({
                url : '{{URL::to("consumption/newcollarcuffItemForm/")}}',
                type : 'get',
                dataType: 'json',
                data:{'id':id,'action_name':action_name}
            }).done(function (data) {
                $('#isi_collarcuff_item_edit').html('');
                $('#isi_collarcuff_item').html(data);
            }).fail(function (msg) {
                alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

        function selectCollarCuffEditForm(action_name,id) {
            if( action_name=="collar" ) {
                document.collarcuffItemFormEdit.action = "/consumption/edit_detail/update_collar_cuff_item";
                $('#judul_collarcuff_item_edit').html('EDIT COLLAR ITEM');
            }
            else if( action_name=="cuff" ) {
                document.collarcuffItemFormEdit.action = "/consumption/edit_detail/update_collar_cuff_item";
                $('#judul_collarcuff_item_edit').html('EDIT CUFF ITEM');
            }

            $.ajax({
                url : '{{URL::to("consumption/editcollarcuffItemForm/")}}',
                type : 'get',
                dataType: 'json',
                data:{'id':id,'action_name':action_name}
            }).done(function (data) {
                $('#isi_collarcuff_item').html('');
                $('#isi_collarcuff_item_edit').html(data);
            }).fail(function (msg) {
                alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

        function pilihSupplier($ls){
            var ls = $ls;
            var ls = $ls;
            $('#supplier_code').val($('#code'+ls).text());
            $('#supplier').val($('#namasup'+ls).text());
            $('#supplier_codelist').fadeOut();
        }

        function pilihColor_form($ls){
            var ls = $ls;
            var ls = $ls;
            $('#color_form').val($('#col'+ls).text());
            $('#color_formlist').fadeOut();
        }

        function pilihFabricconstruct($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_construct').val($('#id_fabricconst'+ls).text());
            $('#fabric_construct').val($('#fabricconst'+ls).text());
            $('#id_fabric_constructlist').fadeOut();
        }

        function pilihFabriccompost($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_compost').val($('#id_fabriccomp'+ls).text());
            $('#fabric_compost').val($('#fabriccomp'+ls).text());
            $('#id_fabric_compostlist').fadeOut();
        }

        function pilihFabricconstructedit($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_construct_edit').val($('#id_fabricconst_edit'+ls).text());
            $('#fabric_construct_edit').val($('#fabricconst_edit'+ls).text());
            $('#id_fabric_constructlist_edit').fadeOut();
        }

        function pilihFabriccompostedit($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_compost_edit').val($('#id_fabriccomp_edit'+ls).text());
            $('#fabric_compost_edit').val($('#fabriccomp_edit'+ls).text());
            $('#id_fabric_compostlist_edit').fadeOut();
        }

        function ModalEditDetail(id){

            id=id;

            $.ajax({
              url : '{{URL::to("consumption/edit_detail_form")}}',
              type : 'get',
              dataType: 'json',
              data:{'id':id}
            }).done(function (data) {
              $('#isi_edit_detail').html(data);
            }).fail(function (msg) {
              alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }


</script>

<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
