<?php

$i_d = 0;
foreach ($mcpd as $detail) {
    $grms[$i_d] = $detail['gramasi'];
    $i_d++;
}

?>

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

    <style type="text/css" media="print">
        @media print {

            body {
                size: 29.7cm 21cm;
                margin-top: 30mm;
            }

            body {
                width: 29.7cm;
                height: 21cm;
                /* -webkit-transform: rotate(-90deg) scale(.68, .68);
                -moz-transform: rotate(-90deg) scale(.58, .58) */
            }

            .logo-teo {
                max-width: 75%;
                max-height: auto;
                vertical-align: middle;
            }

            .name-teo {
                padding-left: 0em;
            }
        }
    </style>

    <style type="text/css">
        body {
            width: 29.7cm;
            height: 21cm;
            /* -webkit-transform: rotate(-90deg) scale(.68, .68);
            -moz-transform: rotate(-90deg) scale(.58, .58) */
        }

        .logo-teo {
            max-width: 75%;
            max-height: auto;
            vertical-align: middle;
        }

        .name-teo {
            padding-left: 0em;
        }
    </style>

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
        <div class="">
            <div class="row">
                <div class="col col-md-2"><img src="{{ asset('assets/images/logo-teodore.png')}}" class="logo-teo"
                        alt="">
                </div>
                <div class="col col-md-6 name-teo">
                    <div class="row font-weight-bold">PT. Teodore Pan Garmindo</div>
                    <div class="row">Jalan Industri IV No.10 Leuwigajah-Cimahi 40533 Bandung, Indonesia
                    </div>
                    <div class="row">Phone: 022-6007272(Hunting) Fax: 022-6007273</div>
                    <div class="row">
                    </div>
                </div>
                <div class="col col-md-1"></div>
                <div class="col col-md-3">
                    <div class="card border-dark mb-3" style="max-width: 18rem;">
                        <div class="card-body text-dark">
                            <div class="row"><small>No.Dokumen : CM-MARK-013</small></div>
                            <div class="row"><small>Tanggal Berlaku : 29-12-2014</small></div>
                            <div class="row"><small>Revisi : {{$mcp->revision_count}}</small></div>
                            <div class="row"><small>Halaman : 1 dari 1</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 justify-content-center">
                <h4>REKAP KONSUMSI KAIN MARKER PRODUKSI</h4>
            </div>

            <div class="row mt-3">
                <div class="col-md-2">Number</div>
                <div class="col-md-3">: {{$mcp->number}}</div>
                <div class="col-md-2">Style Description </div>
                <div class="col-md-3">: {{$mcp->style_desc}}</div>
            </div>
            <div class="row">
                <div class="col-md-2">Order </div>
                <div class="col-md-3">: {{$mcp->order_name}}</div>
                <div class="col-md-2">Delivery Date</div>
                <div class="col-md-3">: {{date("d-m-Y", time())}}</div>
            </div>
            <div class="row">
                <div class="col-md-2">Style </div>
                <div class="col-md-3">: {{$mcp->style}}</div>
                <div class="col-md-2">revisi</div>
                <div class="col-md-3">: {{$mcp->revision_count}}
                </div>
            </div>
            {{-- <div class="col-md-3">{{$mcpt->component}}
        </div> --}}
    </div>

    <div class="row">
        <table class="table table-bordered" style="margin-top: 20px;">
            <thead class="text-center font-weight-bold">
                <th>Marker</th>
                <th>Lebar(')</th>
                <th>Qty(PCS)</th>
                <th>Eff</th>
                <th>Kons KG</th>
                <th>QTY KG</th>
                <th>Act KG</th>
                <th>Kons Yd</th>
                <th>Qty Yd</th>
                <th>Act Yd</th>
                <th>Kons Mtr</th>
                <th>Qty Mtr</th>
                <th>Act Mtr</th>
            </thead>
            <tbody>
                <?php $i_d = 0; ?>
                @foreach ($mcpt as $type)
                @foreach ($mcpd as $det)
                @if ($det->id_type == $type->id)

                <tr class="font-weight-bold">
                    <td>{{$type->component}}</td>
                    <td colspan="4">{{$type->fabricconst}}</td>
                    <td colspan="7">Gramasi : {{$grms[$i_d]}}
                    <td>
                </tr>
                <tr class="font-weight-bold">
                    <td colspan="13">{{$type->warna}}</td>
                </tr>

                @endif
                @endforeach

                <?php
                $tot_qtypcs = 0;
                $tot_eff = 0;
                $tot_konskg = 0;
                $tot_qtykg = 0;
                $tot_actkg = 0;
                $tot_konsyd = 0;
                $tot_qtyyd = 0;
                $tot_actyd = 0;
                $tot_konsmtr = 0;
                $tot_qtymtr = 0;
                $tot_actmtr = 0;
                ?>

                <?php $iteration = 0; ?>
                @foreach ($mcpd as $detail)
                @if ($detail->id_type == $type->id)
                <?php
                $iteration++;

                $kons_kg = ($detail->panjang_m + $detail->tole_pjg_m)*($detail->lebar_m + $detail->tole_lbr_m)*($detail->gramasi/1000)/$detail->total_skala*12;
                $qty_kg = $detail->jml_ampar * $detail->total_skala * $kons_kg/12;

                $kons_yd = ($detail->panjang_m + $detail->tole_pjg_m) / 0.914 / $detail->total_skala * 12;
                $qty_yd = $detail->jml_ampar * $detail->total_skala * $kons_yd/12;

                $kons_mtr = ($detail->panjang_m + $detail->tole_pjg_m) / $detail->total_skala * 12;
                $qty_mtr = $detail->jml_ampar * $detail->total_skala * $kons_mtr/12;

                ?>

                <tr class="text-right">
                    <td></td>
                    <td>{{number_format($detail->lebar_m * 39.37, 2)}}</td>
                    {{-- @foreach ($mcpwsm as $main)
                    @if ($main->id == $type->id_wsheet)
                    <td>{{$main->total_qty}}</td>
                    <?php $tot_qtypcs += $main->total_qty; ?>
                    @endif
                    @endforeach --}}
                    <td>{{$detail->total_skala * $detail->jml_ampar}}</td>
                    <td>{{$detail->efisiensi}} %</td>
                    <td>{{number_format($kons_kg,2)}}
                    </td>
                    <td>{{number_format($qty_kg,2)}}</td>
                    <td>Act KG</td>
                    <td>{{number_format($kons_yd,2)}}</td>
                    <td>{{number_format($qty_yd,2)}}</td>
                    <td>Act Yd</td>
                    <td>{{number_format($kons_mtr,2)}}</td>
                    <td>{{number_format($qty_mtr,2)}}</td>
                    <td>Act Mtr</td>
                </tr>

                <?php
                $tot_eff += $detail->efisiensi;
                $tot_qtypcs += $detail->total_skala * $detail->jml_ampar;
                $tot_konskg += $kons_kg;
                $tot_qtykg += $qty_kg;
                $tot_actkg += 0;
                $tot_konsyd += $kons_yd;
                $tot_qtyyd += $qty_yd;
                $tot_actyd += 0;
                $tot_konsmtr += $kons_mtr;
                $tot_qtymtr += $qty_mtr;
                $tot_actmtr += 0;
                ?>

                @endif

                @endforeach
                <tr class="text-right bg-secondary">
                    <td></td>
                    <td></td>
                    <td>{{$tot_qtypcs}}</td>
                    <td>{{$tot_eff/$iteration}} %</td>
                    <td>{{number_format($tot_konskg/$iteration,2)}}</td>
                    <td>{{number_format($tot_qtykg,2)}}</td>
                    <td>{{number_format($tot_actkg,2)}}</td>
                    <td>{{number_format($tot_konsyd/$iteration,2)}}</td>
                    <td>{{number_format($tot_qtyyd,2)}}</td>
                    <td>{{number_format($tot_actyd,2)}}</td>
                    <td>{{number_format($tot_konsmtr/$iteration,2)}}</td>
                    <td>{{number_format($tot_qtymtr,2)}}</td>
                    <td>{{number_format($tot_actmtr,2)}}</td>
                </tr>

                <?php $i_d++; ?>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        Keterangan : {{$mcp->revisi_remark}}
    </div>

    <br>
    <br>
    <div class="row mt-3">
        <div class="col-sm-3">Tanggal : .............................</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Tanggal : .............................</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Tanggal : .............................</div>
    </div>
    <div class="row">
        <div class="col-sm-3">Disusun Oleh</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Diperiksa Oleh</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3">Disetujui Oleh</div>
    </div>
    <div class="row" style="min-height: 100px;">
        <div class="col-sm-3"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3"></div>
    </div>
    <div class="row">
        <div class="col-sm-3 border-top border-dark text-center">Adm. Cek Produksi</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3 border-top border-dark text-center">MARKER</div>
        <div class="col-sm-1"></div>
        <div class="col-sm-3 border-top border-dark text-center">MGR GARTECH</div>
    </div>
    </div>
    </div>


    <script>
        window.print();
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
