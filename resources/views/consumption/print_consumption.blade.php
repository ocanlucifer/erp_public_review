<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- bootstrap css --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('/css/print_consumption.css')}}">

    <title>
        @guest
        {{ config('app.name', 'Laravel') }}
        @else
        {{ config('app.name', 'Laravel') }} [ {{Auth::user()->user_perusahaan['nama_perusahaan']}} ]
        @endguest
    </title>

</head>

<body>

        @if ($cons->status !== 'CONFIRMED')
        <div id="wm" class="watermark">
                Belum Sah !!
        </div>
        @endif
    <div class="container">
        <div class="row">
            <div class="col col-sm-1"><img src="{{ asset('assets/images/logo-teodore.png')}}" class="logo-teo">
            </div>
            <div class="col col-sm-7 name-teo">
                <div class="row font-weight-bold">PT. Teodore Pan Garmindo</div>
                <div class="row">Jalan Industri IV No.10 Leuwigajah-Cimahi 40533 Bandung, Indonesia
                </div>
                <div class="row">Phone: 022-6007272(Hunting) Fax: 022-6007273</div>
                <div class="row">
                </div>
            </div>
            <div class="col col-sm-4">
                <table>
                    <tr>
                        <td>No. Dokumen</td>
                        <td>:</td>
                        <td>CM-MARK-013</td>
                    </tr>
                    <tr>
                        <td>Tanggal Berlaku</td>
                        <td>:</td>
                        <td>29-12-2014</td>
                    </tr>
                    <tr>
                        <td>Revisi</td>
                        <td>:</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>:</td>
                        <td>1 dari 1</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-4 justify-content-center">
            <h6>REKAP KONSUMSI KAIN UNTUK BUKA PURCHASE ORDER</h6>
        </div>

        <div class="row mt-3">
            <div class="col-sm-2">Order</div>
            <div class="col-sm-2">: {{$cons->styles['name']}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">Sales Order Number</div>
            <div class="col-sm-2">: {{$cons->salesorder->number}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">RKK Number</div>
            <div class="col-sm-2">: {{$cons->code}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Delivery Garment</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->delivery_date))}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Tanggal Dokumen</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->references_date))}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Marker Produksi</div>
            <div class="col-sm-2">: {{$cons->number_mp}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Size Tengah</div>
            <div class="col-sm-2">: {{$cons->size_tengah}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Tanggal Reference</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->references_date))}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Status Dokumen</div>
            <div class="col-sm-6">: {{$cons->status}} @if($cons->unconfirmed_by) By {{$cons->unconfirmedBy['name']}} ({{date('d-m-Y H:i:s', strtotime($cons->unconfirmed_at))}}) @endif</div>
        </div>


        <div class="mt-3">
            
            <table>
                @foreach ($cons_fab as $consfab)
                <thead>
                    <tr>
                        <th colspan="17">
                            <b>{{$consfab->fabricconst['name']}} {{$consfab->fabriccomp['name']}} {{$consfab->description}}</b>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th><b>COLOR</b></th>
                        <th><b>TOTAL QTY</b></th>
                        <th><b>KOMPONEN</b></th>
                        <th><b>LEBAR</b></th>
                        <th><b>CONS BUDGET</b></th>
                        <th><b>CONS MARKER</b></th>
                        <th><b>EFISIENSI MARKER</b></th>
                        <th><b>QTY UNIT</b></th>
                        <th><b>TOL (%)</b></th>
                        <th><b>QTY UNIT + TOL</b></th>
                        <th><b>QTY SAMPLE</b></th>
                        <th><b>QTY PURCH</b></th>
                        <th><b>HARGA BUDGET</b></th>
                        <th><b>HARGA SUPPLIER</b></th>
                        <th><b>UNIT</b></th>
                        <th><b>AMOUNT</b></th>
                        <th><b>AMOUNT + FREIGHT</b></th>
                    </tr>
                </tbody>
                <tbody>
                    @foreach ($consfab->ConsSupplier as $consfabsup)
                    <tr>
                        <th colspan="17" style="text-align: left !important">
                            <b>{{$consfabsup->supplier['nama']}}</b>
                        </th>
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
                        @endforeach
                    <tr style="background-color: #c9ffd8;">
                        <td><b></b></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('total_qty'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('kons_marker'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('qty_unit'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('qty_unit_tole'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('qty_purch'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('supplier_price'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('amount'),2)}}</b></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('amount_freight'),2)}}</b></td>
                    </tr>
                    @endforeach
                </tbody>

                @endforeach
                <tfoot>
                    <tr style="background-color: #a2b8a6;">
                        <td><b></b></td>
                        <td><b>{{number_format($grandtotal_fab['total_qty'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['kons_marker'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg_tole'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['qty_po'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['harga_sup'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['amount_freight'],2)}}</b></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            
            <table>
                @foreach ($cons_collar as $conscollar)
                <thead>
                    <tr>
                        <th colspan="17">
                            <b>{{$conscollar->fabricconst['name']}} {{$conscollar->fabriccomp['name']}} {{$conscollar->description}}</b>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th><b>COLOR</b></th>
                        <th><b>TOTAL QTY</b></th>
                        <th><b>TOL (%)</b></th>
                        <th><b>KG/PCS</b></th>
                        <th><b>TOTAL QTY UNIT</b></th>
                        <th><b>QTY UNIT</b></th>
                        <th><b>HARGA BUDGET</b></th>
                        <th><b>HARGA SUPPLIER</b></th>
                        <th><b>UNIT</b></th>
                        <th><b>AMOUNT</b></th>
                        <th><b>AMOUNT + FREIGHT</b></th>
                        <th><b>DIMENSION</b></th>
                        <th><b>SIZE</b></th>
                        <th><b>TOTAL</b></th>
                        <th><b>TOTAL TOLERANCE</b></th>
                        <th><b>TOTAL ROUNDED</b></th>
                    </tr>
                </tbody>
                <tbody>
                    @foreach ($conscollar->ConsSupplier as $conscollarsup)
                    <tr>
                        <th colspan="17" style="text-align: left !important">
                            <b>{{$conscollarsup->supplier['nama']}}</b>
                        </th>
                    </tr>
                    @foreach ($conscollarsup->collarcuffItem as $collaritem)
                    <tr>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{$collaritem->fab_color['name']}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->total_qty,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->tole,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->qty_unit,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->total_qty_unit_pcs,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->total_qty_unit,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->budget_price,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->supplier_price,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{$collaritem->unit}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->amount,2)}}</td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">{{number_format($collaritem->amount_freight,2)}}</td>
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
                    @endforeach
                    <tr style="background-color: #c9ffd8; ">
                        <td><b></b></td>
                        <td><b>{{number_format($conscollarsup->collarcuffItem->sum('total_qty'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($conscollarsup->collarcuffItem->sum('total_qty_unit'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($conscollarsup->collarcuffItem->sum('supplier_price'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($conscollarsup->collarcuffItem->sum('amount'),2)}}</b></td>
                        <td><b>{{number_format($conscollarsup->collarcuffItem->sum('amount_freight'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
                @endforeach
                <tfoot>
                    <tr style="background-color: #a2b8a6; ">
                        <td><b></b></td>
                        <td><b>{{number_format($grandtotal_collar['total_qty'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_collar['total_qty_unit'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_collar['supplier_price'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_collar['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_collar['amount_freight'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
            <br>
            <table>
                @foreach ($cons_cuff as $conscuff)
                <thead>
                    <tr>
                        <th colspan="17">
                            <b>{{$conscuff->fabricconst['name']}} {{$conscuff->fabriccomp['name']}} {{$conscuff->description}}</b>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th><b>COLOR</b></th>
                        <th><b>TOTAL QTY</b></th>
                        <th><b>TOL (%)</b></th>
                        <th><b>KG/PCS</b></th>
                        <th><b>TOTAL QTY UNIT</b></th>
                        <th><b>QTY UNIT</b></th>
                        <th><b>HARGA BUDGET</b></th>
                        <th><b>HARGA SUPPLIER</b></th>
                        <th><b>UNIT</b></th>
                        <th><b>AMOUNT</b></th>
                        <th><b>AMOUNT + FREIGHT</b></th>
                        <th><b>DIMENSION</b></th>
                        <th><b>SIZE</b></th>
                        <th><b>TOTAL</b></th>
                        <th><b>TOTAL TOLERANCE</b></th>
                        <th><b>TOTAL ROUNDED</b></th>
                    </tr>
                </tbody>
                <tbody>
                    @foreach ($conscuff->ConsSupplier as $conscuffsup)
                    <tr>
                        <td colspan="17" style="text-align: left !important;">
                            <b>{{$conscuffsup->supplier['nama']}}</b>
                        </td>
                    </tr>
                    @foreach ($conscuffsup->collarcuffItem as $collaritem)
                    <tr>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{$collaritem->fab_color['name']}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->total_qty,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->tole,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->qty_unit,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->total_qty_unit_pcs,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->total_qty_unit,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->budget_price,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->supplier_price,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{$collaritem->unit}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->amount,2)}}
                        </td>
                        <td rowspan="{{$collaritem->collarcuffItemSize->count('dimension')+1}}">
                            {{number_format($collaritem->amount_freight,2)}}
                        </td>
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
                    @endforeach
                    <tr style="background-color: #c9ffd8; ">
                        <td><b></b></td>
                        <td><b>{{number_format($conscuffsup->collarcuffItem->sum('total_qty'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($conscuffsup->collarcuffItem->sum('total_qty_unit'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($conscuffsup->collarcuffItem->sum('supplier_price'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($conscuffsup->collarcuffItem->sum('amount'),2)}}</b></td>
                        <td><b>{{number_format($conscuffsup->collarcuffItem->sum('amount_freight'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
                @endforeach
                <tfoot>
                    <tr style="background-color: #a2b8a6; ">
                        <td><b></b></td>
                        <td><b>{{number_format($grandtotal_cuff['total_qty'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_cuff['total_qty_unit'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_cuff['supplier_price'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_cuff['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_cuff['amount_freight'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <br>

            <table>
                <thead>
                    <tr>
                        <th colspan="8" style="background-color: #fff5d1;"><b>TABLE GRAND TOTAL</b></th>
                    </tr>
                    <tr style="background-color: #c2fff9;">
                        <th></th>
                        <th><b>QTY</b></th>
                        <th><b>QTY KG</b></th>
                        <th><b>QTY KG + TOLERANCE</b></th>
                        <th><b>QTY PO</b></th>
                        <th><b>HARGA SUPPLIER</b></th>
                        <th><b>AMOUNT</b></th>
                        <th><b>AMOUNT + FREIGHT</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>TOTAL FABRIC</b></td>
                        <td><b>{{number_format($grandtotal_fab['total_qty'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg_tole'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['qty_po'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['harga_sup'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_fab['amount_freight'],2)}}</b></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL COLLAR</b></td>
                        <td><b>{{number_format($grandtotal_collar['total_qty'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_collar['total_qty_unit'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_collar['supplier_price'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_collar['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_collar['amount_freight'],2)}}</b></td>
                    </tr>
                    <tr>
                        <td><b>TOTAL CUFF</b></td>
                        <td><b>{{number_format($grandtotal_cuff['total_qty'],2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_cuff['total_qty_unit'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_cuff['supplier_price'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_cuff['amount'],2)}}</b></td>
                        <td><b>{{number_format($grandtotal_cuff['amount_freight'],2)}}</b></td>
                    </tr>
                    <?php
                        $gr_total_qty= $grandtotal_fab['total_qty'] + $grandtotal_collar['total_qty'] + $grandtotal_cuff['total_qty'];
                        $gr_qty_kg= $grandtotal_fab['qty_kg'];
                        $gr_qty_kg_tole= $grandtotal_fab['qty_kg_tole'];
                        $gr_qty_po= $grandtotal_fab['qty_po'] + $grandtotal_collar['total_qty_unit'] + $grandtotal_cuff['total_qty_unit'];
                        $gr_harga_sup= $grandtotal_fab['harga_sup'] + $grandtotal_collar['supplier_price'] + $grandtotal_cuff['supplier_price'];
                        $gr_amount= $grandtotal_fab['amount'] + $grandtotal_collar['amount'] + $grandtotal_cuff['amount'];
                        $gr_amount_freight= $grandtotal_fab['amount_freight'] + $grandtotal_collar['amount_freight'] + $grandtotal_cuff['amount_freight'];
                    ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: #c2fff9;">
                        <td><b>GRAND TOTAL</b></td>
                        <td><b>{{number_format($gr_total_qty,2)}}</b></td>
                        <td><b>{{number_format($gr_qty_kg,2)}}</b></td>
                        <td><b>{{number_format($gr_qty_kg_tole,2)}}</b></td>
                        <td><b>{{number_format($gr_qty_po,2)}}</b></td>
                        <td><b>{{number_format($gr_harga_sup,2)}}</b></td>
                        <td><b>{{number_format($gr_amount,2)}}</b></td>
                        <td><b>{{number_format($gr_amount_freight,2)}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <br>

        <div class="row">
            <div class="col-sm-2">Quantity Pcs Order</div>
            <div class="col-sm-2">: {{round($cons->quotation['forecast_qty'],2)}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Quantity Pcs RKK</div>
            <div class="col-sm-2">: {{round($total_qty_fab,2)}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">Harga Garment Nett</div>
            <div class="col-sm-2">: {{number_format($cons->quotation['totalcost_handling_margin'],2)}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">Nett Sales</div>
            <div class="col-sm-2">: {{number_format($nett_sales,2)}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">% PO</div>
            <div class="col-sm-2">: {{number_format($purchasing_percentage,2)}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">Konsumsi Per Dz</div>
            <div class="col-sm-2">: <i class="@if($budget_status=='OVER BUDGET') text-danger font-weight-bold @endif">&nbsp {{number_format($cons_per_dz,2)}} &nbsp </i> &nbsp&nbsp&nbsp Budget( {{number_format($budget,2)}} )</div>
        </div>

        <br>

        <?php
            $localdate      = $cons->delivery_date;
            $idealfabric    = date('Y-m-d', strtotime('-30 days', strtotime($localdate)));
            $ideallatest    = date('Y-m-d', strtotime('-75 days', strtotime($localdate)));   
        ?>

        <div class="row">
            <div class="col-sm-2"><b>T&A (UNTUK SUPPLIER LOCAL)</b></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2"><b>AKTUAL</b></div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Delivery Garment</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->delivery_date))}}</div>
            <div class="col-sm-2">Buka PO</div>
            <div class="col-sm-2">: ...........................................</div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Ideal Fabric In Teo</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($idealfabric))}} (-30 Hari)</div>
            <div class="col-sm-2">Delivery di PO</div>
            <div class="col-sm-2">: ...........................................</div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Ideal Latest Pass PO ke Supplier</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($ideallatest))}} (-75 Hari)</div>
        </div>

        <br>

        <?php
            $luardate           = $cons->delivery_date;
            $idealuarfabric     = date('Y-m-d', strtotime('-30 days', strtotime($luardate)));
            $idealuaretd        = date('Y-m-d', strtotime('-44 days', strtotime($luardate)));   
            $idealuarlatest     = date('Y-m-d', strtotime('-74 days', strtotime($luardate)));   
        ?>

        <div class="row">
            <div class="col-sm-3"><b>T&A (UNTUK SUPPLIER IMPORT)</b></div>
            <div class="col-sm-1"></div>
            <div class="col-sm-2"><b>AKTUAL</b></div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Delivery Garment</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->delivery_date))}}</div>
            <div class="col-sm-2">Buka PO</div>
            <div class="col-sm-2">: ...........................................</div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Ideal Fabric In Teo</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($idealuarfabric))}} (-30 Hari)</div>
            <div class="col-sm-2">Delivery di PO</div>
            <div class="col-sm-2">: ...........................................</div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Ideal ETD Supplier</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($idealuaretd))}} (-44 Hari)</div>
        </div>
        <div class="row">
            <div class="col-sm-2">&nbsp&nbsp&nbsp Ideal Latest Pass PO ke Supplier</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($idealuarlatest))}} (-74 Hari)</div>
        </div>

    </div>

    <br>
    <br>
    <div class="container avoid-break">
        <b>
        <div class="row">
            <div class="col">Tanggal : {{date('d-m-Y', strtotime($cons->created_at))}}</div>
            <div class="col"></div>
            <div class="col">Tanggal : @if ($cons->reviewed_at) {{date('d-m-Y', strtotime($cons->reviewed_at))}} @endif</div>
            <div class="col"></div>
            <div class="col">Tanggal : @if ($cons->confirmed_at) {{date('d-m-Y', strtotime($cons->confirmed_at))}} @endif</div>
        </div>
        <div class="row">
            <div class="col">Dibuat Oleh :</div>
            <div class="col"></div>
            <div class="col">Diperiksa Oleh :</div>
            <div class="col"></div>
            <div class="col">Distujui Oleh :</div>
        </div>
        <div class="row" style="min-height: 70px;">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col border-top border-dark text-center">{{$cons->createdBy['name']}}</div>
            <div class="col"></div>
            <div class="col border-top border-dark text-center">{{$cons->reviewedBy['name']}}</div>
            <div class="col"></div>
            <div class="col border-top border-dark text-center">{{$cons->confirmedBy['name']}}</div>
        </div>
        </b>
        <br>
        <br>
    </div>

    <script>
        // window.print();
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function(){
        addWM();
    });
    function addWM(){
        var text = '';

        for(var i=0; i<430; i++)
        {
            text += 'Belum Sah..!! ';
        }

        $('#wm').html(text);
    }
</script>
