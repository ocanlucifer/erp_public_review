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
    <link rel="stylesheet" type="text/css" href="{{url('/css/mcp_print.css')}}">

    <style type="text/css" media="print">

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
    @foreach ($mpt as $t)
    @if ($t->type == "KAIN KERAS")

    @endif
    <div class="container page-break">
        {{-- header --}}
        <div class="row">
            <div class="col col-md-2"><img src="{{ asset('assets/images/logo-teodore.png')}}" class="logo-teo" alt="">
            </div>
            <div class="col col-md-6 name-teo">
                <div class="row font-weight-bold">PT. Teodore Pan Garmindo</div>
                <div class="row">Jalan Industri IV No.10 Leuwigajah-Cimahi 40533 Bandung, Indonesia
                </div>
                <div class="row">Phone: 022-6007272(Hunting) Fax: 022-6007273</div>
                <div class="row">
                </div>
            </div>
            <div class="col col-md-4">
                <table>
                    <tr>
                        <td>No. Dokumen</td>
                        <td>:</td>
                        <td>CM-MARK-010</td>
                    </tr>
                    <tr>
                        <td>Tanggal Berlaku</td>
                        <td>:</td>
                        <td>29-12-2014</td>
                    </tr>
                    <tr>
                        <td>Revisi</td>
                        <td>:</td>
                        <td>{{$mp->revision_count}}</td>
                    </tr>
                    <tr>
                        <td>Halaman</td>
                        <td>:</td>
                        <td>1 dari 1</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row mt-3 justify-content-center">
            @if ($t->type == "KAIN KERAS")
            <h4>Rekapitulasi Perhitungan Kain Aplikasi (Summary Of Fabric Calculation)</h4>
            @else
            <h4>Rekapitulasi Perhitungan Kain (Summary Of Fabric Calculation)</h4>
            @endif
        </div>
        {{-- end of header --}}

        {{-- header content --}}
        <div class="row mt-3">
            <div class="col-md-1">Kode</div>
            <div class="col-md-4">: {{$mp->number}}</div>
            <div class="col-md-1">Order </div>
            <div class="col-md-4">: {{$mp->order_name}}</div>
        </div>
        <div class="row">
            <div class="col-md-1">Tanggal</div>
            <div class="col-md-4">: {{date("d-m-Y", strtotime($mp->delivery_date))}}</div>
            <div class="col-md-1">Style </div>
            <div class="col-md-4">: {{$mp->style}}</div>
        </div>
        <div class="row">
            <div class="col-md-1">Kain</div>
            <div class="col-md-4">: {{$t->fabricconst}} {{$t->fabriccomp}} {{$t->fabricdesc}}</div>
            <div class="col-md-1">Warna </div>
            <div class="col-md-4">: {{$t->warna}}</div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4"></div>
            <div class="col-md-1">Combo </div>
            <div class="col-md-4">: {{$mpwsm->combo}}</div>
            <div class="col-md-1">{{$t->component}}</div>
        </div>
        {{-- end of header content --}}

        {{-- TABEL TURUN SIZE --}}
        <div class="row mt-5">
            <div class="col-sm-12">
                <table>
                    <tr>
                        <td>Size</td>
                        @foreach ($mpws as $ws)
                        <td>{{$ws->size}}</td>
                        @endforeach
                        <td>Marker</td>
                        <td>Ampar</td>
                        <td>Total</td>
                    </tr>
                    <tr>
                        <td>Qty WS</td>
                        <?php $qty_ws_tot = 0; ?>
                        @foreach ($mpws as $ws)
                        <?php $qty_ws_tot += $ws->ws_qty; ?>
                        <td>{{$ws->ws_qty}}</td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td>{{$qty_ws_tot}}</td>
                    </tr>
                    <?php $sby = 0;?>
                    @foreach ($mpd as $d)
                    @if ($d->id_type == $t->id)
                    <tr>
                        <td>M {{$d->urutan}}</td>

                        <?php $sbx = 0;?>
                        @foreach ($mpa as $a)
                        @foreach ($mpws as $ws)
                        @if (($a->id_ws == $ws->id) && ($a->id_mpd == $d->id))

                        <?php $markerp[$sby][$sbx] = $a->scale * $d->jml_marker * $d->jml_ampar; ?>
                        <td>{{$a->scale}}</td>

                        <?php $sbx++;?>
                        @endif
                        @endforeach
                        @endforeach

                        <td>{{$d->jml_marker}}</td>
                        <td>{{$d->jml_ampar}}</td>
                        <td></td>
                    </tr>

                    <?php
                    for ($i=1; $i < $sby; $i++) {
                        for ($j=1; $j < $sbx; $j++) {
                            $markerp[$i][$j] += $markerp[$i][$j];
                        }
                    }
                    $sby++;
                    ?>

                    @endif
                    @endforeach

                    <?php
                    for ($j=0; $j < $sbx; $j++) {
                        $qtymp[$j] = 0;
                        for ($i=0; $i < $sby; $i++) {
                            $qtymp[$j] += $markerp[$i][$j];
                        }
                    }
                    ?>

                    <tr>
                        <td>Qty MP</td>
                        <?php
                        $totqtymp = 0;
                        for ($j=0; $j < $sbx ; $j++) {
                        ?>
                        <td>{{$qtymp[$j]}}</td>
                        <?php $totqtymp += $qtymp[$j]; ?>
                        <?php } ?>

                        <?php
                        $j = 0;
                        foreach ($mpws as $ws) {
                            $wsfor_turunsize[$j] = $ws->ws_qty;
                            $j++;
                        }
                        ?>

                        <td></td>
                        <td></td>
                        <td>{{$totqtymp}}</td>
                    </tr>
                    <tr>
                        <td>Turun Size</td>
                        <?php for ($i=0; $i < $j; $i++) { ?>
                        <td><?= $qtymp[$i] - $wsfor_turunsize[$i]; ?></td>
                        <?php } ?>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- END OF TABEL TURUN SIZE --}}

        {{-- TABEL MARKER DESC --}}
        <?php
        $fabtot_kg = 0;
        $fabtot_mtr = 0;
        $fabtot_yd = 0;
        ?>

        @foreach ($mpd as $d)
        @if ($d->id_type == $t->id)

        <div class="row mt-4"> Marker Ke - {{$d->urutan}}</div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <table>
                    <tr>
                        <td>Size</td>
                        @foreach ($mpws as $ws)
                        <td>{{$ws->size}}</td>
                        @endforeach
                        <td>Marker</td>
                        <td>Ampar</td>
                        <td>Total</td>
                    </tr>
                    <tr>
                        <td>Assort</td>

                        <?php $sbx = 0;?>
                        @foreach ($mpa as $a)
                        @foreach ($mpws as $ws)
                        @if (($a['id_ws'] == $ws['id']) && ($a['id_mpd'] == $d['id']))
                        <?php $qtyws[$sby][$sbx] = $a->scale * $d->jml_marker * $d->jml_ampar; ?>
                        <td>{{$a->scale}}</td>

                        <?php $sbx++;?>
                        @endif
                        @endforeach
                        @endforeach

                        <td>{{$d->jml_marker}}</td>
                        <td>{{$d->jml_ampar}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Hasil</td>

                        <?php $sbx = 0;?>
                        <?php $totws_hasil = 0; ?>
                        @foreach ($mpa as $a)
                        @foreach ($mpws as $ws)
                        @if (($a['id_ws'] == $ws['id']) && ($a['id_mpd'] == $d['id']))

                        <td>{{$qtyws[$sby][$sbx]}}</td>
                        <?php
                        $totws_hasil += $qtyws[$sby][$sbx];
                        $sbx++;
                        ?>

                        @endif
                        @endforeach
                        @endforeach
                        <td></td>
                        <td></td>
                        <td>{{$totws_hasil}}</td>
                    </tr>
                </table>

                <div class="mt-3" style="font-weight: normal !important;">
                    {{-- konsumsi kg/dz--}}
                    <!-- Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12  -->
                    <span>Konsumsi </span>: P = {{$d->panjang_m}} m + {{$d->tole_pjg_m}} m , L =
                    {{$d->lebar_m}} m +
                    {{$d->tole_lbr_m}} m
                    </br>

                    <span style="opacity: 0">Konsumsi </span>:
                    {{sprintf("%.2f",($d->panjang_m + $d->tole_pjg_m))}} x
                    {{sprintf("%.2f", ($d->lebar_m + $d->tole_lbr_m))}} x
                    {{sprintf("%.2f",($d->gramasi/1000))}} /
                    {{$d->total_skala}} x 12
                    </br>

                    <span style="opacity: 0">Konsumsi </span>:
                    {{$kons_kgdz = sprintf("%.2f",($d->panjang_m + $d->tole_pjg_m) * ($d->lebar_m + $d->tole_lbr_m) * ($d->gramasi/1000) / $d->total_skala * 12)}}Kg/dz
                    </br>

                    {{-- quantity --}}
                    <span>Quantity </span>: {{$totws_hasil}} x {{$kons_kgdz}} / 12 pcs =
                    {{$qty_kgdz = sprintf("%.2f",($totws_hasil * $kons_kgdz/ 12))}} Kg
                    </br>

                    {{-- konsumsi mtr/dz and yd/dz --}}
                    <!-- Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12  -->
                    <!-- Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi) / 0.914 / Skala x 12 -->
                    Konsumsi : P = {{$d->panjang_m}} m + {{$d->tole_pjg_m}} m > {{$d->panjang_m + $d->tole_pjg_m}} /
                    {{$d->total_skala}} x 12 =
                    {{$kons_mdz = sprintf("%.2f",(($d->panjang_m + $d->tole_pjg_m)/$d->total_skala*12))}} Mtr/Dz =
                    {{$kons_yddz = sprintf("%.2f", ($d->panjang_m + $d->tole_pjg_m)/0.914/$d->total_skala*12)}}
                    Yard/Dz
                    </br>

                    Quantity : {{$totws_hasil}} x {{$kons_mdz}} / 12 =
                    {{$qty_mdz = sprintf("%.2f",($totws_hasil * $kons_mdz / 12))}} m =
                    {{$qty_yddz = sprintf("%.2f",($totws_hasil * $kons_yddz / 12))}} Yard
                    </br>

                    <?php
                    $fabtot_kg += $qty_kgdz;
                    $fabtot_mtr += $qty_mdz;
                    $fabtot_yd += $qty_yddz;
                    ?>
                </div>
            </div>
        </div>

        @endif
        @endforeach
        {{-- END OF TABEL MARKER DESC --}}

        <hr style="border: 1px solid black; border-width: thin;" class="mt-4">
        <div class="container">
        </div>

        <div class="row">
            <div class="col-sm-6">Total fabric : {{sprintf("%.2f",$fabtot_kg)}} Kg,
                {{sprintf("%.2f",$fabtot_mtr)}} Mtr,
                {{sprintf("%.2f",$fabtot_yd)}} Yard</div>
            <div class="col-sm-6">Jumlah Marker : {{$sby}}</div>
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
    @endforeach


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
