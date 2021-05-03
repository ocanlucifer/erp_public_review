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
                            <div class="row"><small>No.Dokumen : CM-MARK-010</small></div>
                            <div class="row"><small>Tanggal Berlaku : 29-12-2014</small></div>
                            <div class="row"><small>Revisi : {{$mcpd->revisi}}</small></div>
                            <div class="row"><small>Halaman : 1 dari 1</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 justify-content-center">
                <h4>Rekapitulasi Perhitungan Kain (Summary Of Fabric Calculation)</h4>
            </div>

            <div class="row mt-3">
                <div class="col-md-1">Kode</div>
                <div class="col-md-3">: {{$mcp->number}}</div>
                <div class="col-md-1">Order </div>
                <div class="col-md-3">: {{$mcp->order_name}}</div>
            </div>
            <div class="row">
                <div class="col-md-1">Tanggal</div>
                <div class="col-md-3">: {{date("d-m-Y", strtotime($mcpd->marker_date))}}</div>
                <div class="col-md-1">Style </div>
                <div class="col-md-3">: {{$mcp->style}}</div>
            </div>
            <div class="row">
                <div class="col-md-1">Kain</div>
                <div class="col-md-3">: {{$mcp->fabric_const}}</div>
                <div class="col-md-1">Warna </div>
                <div class="col-md-3">: {{$mcpt->warna}}</div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-3"></div>
                <div class="col-md-1">Combo </div>
                <div class="col-md-3">: {{$mcpwsm->combo}}</div>
                <div class="col-md-3">{{$mcpt->component}}</div>
            </div>

            <div class="row">
                <div class="row mt-3 table-responsive">
                    <table class="table table-bordered ">
                        <thead class="text-center">
                            <th>Size</th>
                            @foreach ($mcpa as $ass)
                            <th>{{$ass->size}}</th>
                            @endforeach
                            <th>Marker</th>
                            <th>Ampar</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><b>Qty Ws</b></td>
                                <?php $qtyws = 0; ?>
                                @foreach ($mcpa as $ass)
                                <td>{{$ass->qty_ws}}</td>
                                <?php $qtyws += $ass->qty_ws; ?>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td>{{$qtyws}}</td>
                            </tr>
                            <tr class="text-center">
                                <td><b>M {{$mcpt->no_urut}}</b></td>
                                @foreach ($mcpa as $ass)
                                <td>{{$ass->scale}}</td>
                                @endforeach
                                <td>{{$mcpd->jml_marker}}</td>
                                <td>{{$mcpd->jml_ampar}}</td>
                                <td></td>
                            </tr>
                            <tr class="text-center">
                                <td><b>Qty MP</b></td>
                                <?php $qtymp_t = 0; ?>
                                @foreach ($mcpa as $ass)
                                <?php $qtymp = $ass->scale * $mcpd->jml_ampar;?>
                                <td>{{$qtymp}}</td>
                                <?php $qtymp_t += $qtymp; ?>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td>{{$qtymp_t}}</td>
                            </tr>
                            <tr class="text-center">
                                <td><b>Turun Size</b></td>
                                @foreach ($mcpa as $ass)
                                <td>{{$turun = ($ass->scale * $mcpd->jml_ampar) - $ass->qty_ws}}</td>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                {{'Marker Ke-'.$mcpwsm->no_urut}}
            </div>

            <div class="row mt-3">
                <div class="row mt-3 table-responsive">
                    <table class="table table-bordered ">
                        <thead class="text-center">
                            <th>Size</th>
                            @foreach ($mcpa as $ass)
                            <th>{{$ass->size}}</th>
                            @endforeach
                            <th>Marker</th>
                            <th>Ampar</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><b>Assort</b></td>
                                <?php $scale_t = 0; ?>
                                @foreach ($mcpa as $ass)
                                <td>{{$ass->scale}}</td>
                                <?php $scale_t += $ass->scale; ?>
                                @endforeach
                                <td>{{$mcpd->jml_marker}}</td>
                                <td>{{$mcpd->jml_ampar}}</td>
                                <td></td>
                            </tr>
                            <tr class="text-center">
                                <td><b>Hasil</b></td>
                                <?php $qtymp_t = 0; ?>
                                @foreach ($mcpa as $ass)
                                <?php $qtymp = $ass->scale * $mcpd->jml_ampar;?>
                                <td>{{$qtymp}}</td>
                                <?php $qtymp_t += $qtymp; ?>
                                @endforeach
                                <td></td>
                                <td></td>
                                <td>{{$qtymp_t}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-1">Konsumsi</div>
                <div class="col-sm-3">: P = {{$mcpd->panjang_m}} m + {{$mcpd->tole_pjg_m}} m</div>
            </div>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-3">: L = {{$mcpd->lebar_m}} m + {{$mcpd->tole_lbr_m}} m</div>
                <div class="col-sm-3">> {{$scale_t}} / {{$mcpd->gramasi}} x 12 PCS</div>
                {{-- Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12 --}}
                <div class="col-sm-2">=
                    {{$kons_kgdz = sprintf("%.2f",($mcpd->panjang_m + $mcpd->tole_pjg_m) * ($mcpd->lebar_m + $mcpd->tole_lbr_m) * ($mcpd->gramasi/1000) / $mcpd->total_skala * 12)}}
                    Kg/dz</div>
            </div>

            <div class="row">
                <div class="col-sm-1">Quantity</div>
                <div class="col-sm-3">: {{$qtymp_t}} x
                    {{$kons_kgdz}} / 12 PCS</div>
                <div class="col-sm-3">= {{$qty_kgdz = sprintf("%.2f",($qtymp_t * $kons_kgdz/ 12))}} Kg
                </div>
            </div>

            {{-- Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12 --}}
            {{-- Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi) / 0.914 / Skala x 12 --}}
            <div class="row">
                <div class="col-sm-1">Konsumsi</div>
                <div class="col-sm-3">: P = {{$mcpd->panjang_m}} m + {{$mcpd->tole_pjg_m}} m</div>
                <div class="col-sm-3">> {{$mcpd->total_skala}} x 12 PCS</div>
                <div class="col-sm-2">=
                    {{$kons_mdz = sprintf("%.2f",(($mcpd->panjang_m + $mcpd->tole_pjg_m)/$mcpd->total_skala*12))}}
                    Mtr/Dz
                </div>
                <div class="col-sm-2">= {{sprintf("%.2f",$kons_mdz * 1.094)}} Yard/Dz</div>
            </div>

            <div class="row">
                <div class="col-sm-1">Quantity</div>
                <div class="col-sm-3">: {{$qtymp_t}} x {{$kons_mdz}} / 12</div>
                <div class="col-sm-3">= {{$qty_mdz = sprintf("%.2f",($qtymp_t * $kons_mdz / 12))}} m</div>
                <div class="col-sm-2">= {{$qty_yddz = sprintf("%.2f",($qty_mdz * 1.094))}} Yard</div>
            </div>

            <hr class="mb-20">

            <div class="row font-weight-bold">
                <div class="col-sm-5">Total Fabric : {{$qty_kgdz}} Kg, {{$qty_mdz}} Mtr, {{$qty_yddz}} Yard </div>
                <div class="col-sm-3">Jumlah Marker : {{$mcpd->jml_marker}}</div>
            </div>

            <br>
            <br>
            <div class="row mt-3">
                <div class="col">Tanggal : .............................</div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">Tanggal : .............................</div>
                <div class="col"></div>
            </div>
            <div class="row">
                <div class="col">Disusun Oleh</div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col">Diperiksa Oleh</div>
                <div class="col"></div>
            </div>
            <div class="row" style="min-height: 100px;">
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <div class="row">
                <div class="col border-top border-dark">ADM. CEK PROD</div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col border-top border-dark">MGR GARTECH</div>
                <div class="col"></div>
            </div>
        </div>
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
