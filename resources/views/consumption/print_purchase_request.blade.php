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
        </div>

        <div class="row mt-4 justify-content-center">
            <h6>PURCHASE REQUEST</h6>
        </div>

        <div class="row">
            <div class="col-sm-2">RKK Number</div>
            <div class="col-sm-2">: {{$cons->code}}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2">Sales Order Number</div>
            <div class="col-sm-2">: {{$cons->salesorder->number}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Quotation</div>
            <div class="col-sm-2">: {{$cons->code_quotation}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Style</div>
            <div class="col-sm-2">: {{$cons->styles['name']}}</div>
        </div>

        <div class="row">
            <div class="col-sm-2">Delivery Date</div>
            <div class="col-sm-2">: {{date('d F Y', strtotime($cons->delivery_date))}}</div>
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
                        <th><b>KONS MARKER</b></th>
                        <th><b>EFISIENSI MARKER</b></th>
                        <th><b>QTY KG</b></th>
                        <th><b>TOL (%)</b></th>
                        <th><b>QTY KG + TOL</b></th>
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
                            <td>{{number_format($fabitem->kons_marker,2)}}</td>
                            <td>{{number_format($fabitem->kons_efi,2)}}</td>
                            <td>{{number_format($fabitem->qty_unit,2)}}</td>
                            <td>{{number_format($fabitem->tole,2)}}</td>
                            <td>{{number_format($fabitem->qty_unit_tole,2)}}</td>
                        </tr>
                        @endforeach
                    <tr style="background-color: #c9ffd8;">
                        <td><b></b></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('total_qty'),2)}}</b></td>
                        <td></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('kons_marker'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('qty_unit'),2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($consfabsup->FabItem->sum('qty_unit_tole'),2)}}</b></td>
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
                        <td><b>{{number_format($grandtotal_fab['kons_marker'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg'],2)}}</b></td>
                        <td></td>
                        <td><b>{{number_format($grandtotal_fab['qty_kg_tole'],2)}}</b></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <br>

        </div>
        <br>

    </div>

    <br>
    <br>
    <div class="container avoid-break">
        <div class="row">
            <div class="col-sm-2">
                <table>
                    <tr>
                        <td>Purchasing</td>
                        <td>{{$cons->createdBy['name']}}</td>
                    </tr>
                    <tr>
                        <td>Checked By</td>
                        <td>{{$cons->reviewedBy['name']}}</td>
                    </tr>
                    <tr>
                        <td>Approved By</td>
                        <td>{{$cons->confirmedBy['name']}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
                <div class="row"><b>Accepted and Confirmed</b></div>
                <br>
                <div class="row">
                    <div class="col-sm-2">Name</div>
                    <div class="col-sm-3">: ...................................................</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-2">Title</div>
                    <div class="col-sm-3">: ...................................................</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-3">(Authorized Signatory)</div>
                </div>
            </div>
        </div>
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
