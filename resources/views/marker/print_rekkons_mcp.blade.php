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
    <link rel="stylesheet" type="text/css" href="{{url('/css/rekap_mcp.css')}}">

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
                        <td>{{$mcp->revision_count}}</td>
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
            <h6>REKAP KONSUMSI KAIN MASKER PRODUKSI</h6>
        </div>

        <div class="row mt-3">
            <div class="col-sm-2">NUMBER</div>
            <div class="col-sm-2">: {{$mcp->number}}</div>
            <div class="col-sm-2">STYLE DESCRIPTION</div>
            <div class="col-sm-2">: {{$mcp->style_desc}}</div>
        </div>
        <div class="row">
            <div class="col-sm-2">ORDER</div>
            <div class="col-sm-2">: {{$mcp->order_name}}</div>
            <div class="col-sm-2">DELIVERY DATE</div>
            <div class="col-sm-2">: {{date("d-m-Y", strtotime($mcp->delivery_date))}}</div>
        </div>
        <div class="row">
            <div class="col-sm-2">STYLE</div>
            <div class="col-sm-2">: {{$mcp->style}}</div>
            <div class="col-sm-2">REVISI</div>
            <div class="col-sm-2">: {{$mcp->revision_count}}</div>
        </div>

        @if ($mcp->state !== 'CONFIRMED')
        <div class="text-center">

            <h1 class="text-danger font-weight-bold">______________ NOT CONFIRMED ______________</h1>

        </div>
        @endif

        <div class="mt-3">
            <table>
                {{-- TABLE MARER DAN KAIN KERAS --}}
                <tr class="no-border">
                    <th><b>Marker</b></th>
                    <th><b>Lebar(')</b></th>
                    <th><b>Qty (PCS)</b></th>
                    <th><b>Eff</b></th>
                    <th><b>Kons KG</b></th>
                    <th><b>Qty KG</b></th>
                    <th><b>Act KG</b></th>
                    <th><b>Kons Yd</b></th>
                    <th><b>Qty Yd</b></th>
                    <th><b>Act Yd</b></th>
                    <th><b>Kons Mtr</b></th>
                    <th><b>Qty Mtr</b></th>
                    <th><b>Act Mtr</b></th>
                </tr>
                @foreach ($mcpwsm as $wsm)
                @foreach ($mcpt as $t)
                @if ($t->type != "PIPING")


                <tr class="no-border">
                    <td>{{$t->component}}</td>
                    <td colspan="4">{{$t->fabricdesc}}</td>

                    <?php $totgramasi = 0.0; $amount = 0; ?>
                    @foreach ($mcpd as $d)
                    @if ($d->id_type == $t->id)

                    <?php $totgramasi += $d->gramasi; $amount++ ?>

                    @endif
                    @endforeach
                    {{-- end foreach mcpd --}}
                    <td colspan="8">Gramasi : {{$totgramasi/$amount}}</td>
                </tr>
                <tr>
                    <td colspan="13" style="text-align: left; padding-left: 3%">{{$t->warna}}</td>
                </tr>

                {{-- inisialisasi variabel total --}}
                <?php
                $tot_qty = 0.0;
                $tot_eff = 0.0;
                $avg_eff = 0.0;
                $tot_kons_kg = 0.0;
                $tot_kons_yd = 0.0;
                $tot_kons_mtr = 0.0;
                $avg_kons_kg = 0.0;
                $avg_kons_yd = 0.0;
                $avg_kons_mtr = 0.0;
                $tot_qty_kg = 0.0;
                $tot_qty_yd = 0.0;
                $tot_qty_mtr = 0.0;
                $tot_act_kg = 0.0;
                $tot_act_yd = 0.0;
                $tot_act_mtr = 0.0;

                $i = 0;
                ?>

                @foreach ($mcpd as $d)
                @if ($d->id_type == $t->id)

                <?php
                $total_scales = 0.0;
                foreach ($mcpa as $a) {
                    if ($a->id_mcpd == $d->id) {
                        $total_scales += ($a->scale * $d->jml_marker * $d->jml_ampar);
                    }
                }

                // • Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x Gramasi / 1000 / Skala x 12
                $kons_kg = sprintf("%.2f",($d->panjang_m + $d->tole_pjg_m) * ($d->lebar_m + $d->tole_lbr_m) * ($d->gramasi/1000) / $d->total_skala * 12);

                // • Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi) / 0.914 / Skala x 12
                $kons_yd = sprintf("%.2f",($d->panjang_m + $d->tole_pjg_m) / 0.914 / $d->total_skala * 12);

                // • Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12
                $kons_mtr = sprintf("%.2f",($d->panjang_m + $d->tole_pjg_m) / $d->total_skala * 12);

                // • Perhitungan Qty per Yard, Kg dan meter = Jumlah Ampar x Total Skala x Konsumsi / 12
                $qty_kg = sprintf("%.2f",($d->jml_ampar * $d->total_skala * $kons_kg /12));
                $qty_yd = sprintf("%.2f",($d->jml_ampar * $d->total_skala * $kons_yd /12));
                $qty_mtr = sprintf("%.2f",($d->jml_ampar * $d->total_skala * $kons_mtr /12));

                // • Perhitungan Act per Yard, Kg dan meter = Qty x efisiensi / 100
                $act_kg = sprintf("%.2f", ($qty_kg * $d->efisiensi / 100));
                $act_yd = sprintf("%.2f", ($qty_yd * $d->efisiensi / 100));
                $act_mtr = sprintf("%.2f", ($qty_mtr * $d->efisiensi / 100));

                // =============================
                // perhitungan total dan average
                $tot_qty += $total_scales;
                $tot_eff += $d->efisiensi;
                $tot_kons_kg += $kons_kg;
                $tot_kons_yd += $kons_yd;
                $tot_kons_mtr += $kons_mtr;
                $tot_qty_kg += $qty_kg;
                $tot_qty_yd += $qty_yd;
                $tot_qty_mtr += $qty_mtr;
                $tot_act_kg += $act_kg;
                $tot_act_yd += $act_yd;
                $tot_act_mtr += $act_mtr;
                ?>

                <tr>
                    <td></td>
                    <td>{{sprintf("%.2f",($d->lebar_m))}}</td>
                    <td>{{$total_scales}}</td>
                    <td>{{sprintf("%.2f",($d->efisiensi))}}%</td>
                    <td>{{sprintf("%.2f",($kons_kg))}}</td>
                    <td>{{sprintf("%.2f",($qty_kg))}}</td>
                    <td>{{sprintf("%.2f",($act_kg = $qty_kg * $d->efisiensi / 100))}}</td>
                    <td>{{sprintf("%.2f",($kons_yd))}}</td>
                    <td>{{sprintf("%.2f",($qty_yd))}}</td>
                    <td>{{sprintf("%.2f",($act_yd = $qty_yd * $d->efisiensi / 100))}}</td>
                    <td>{{sprintf("%.2f",($kons_mtr))}}</td>
                    <td>{{sprintf("%.2f",($qty_mtr))}}</td>
                    <td>{{sprintf("%.2f",($act_mtr = $qty_mtr * $d->efisiensi / 100))}}</td>
                </tr>

                <?php $i++; ?>
                @endif
                {{-- end if d->id_type == t->id  --}}
                @endforeach
                {{-- end foreach mcpd --}}

                <tr class="no-border bg-col">
                    <td></td>
                    <td></td>
                    <td>{{$tot_qty}}</td>
                    <td>{{sprintf("%.2f",($tot_eff / $i))}}%</td>
                    <td>{{sprintf("%.2f", ($tot_kons_kg / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_kg))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_kg))}}</td>
                    <td>{{sprintf("%.2f", ($tot_kons_yd / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_yd))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_yd))}}</td>
                    <td>{{sprintf("%.2f", ($tot_kons_mtr / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_mtr))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_mtr))}}</td>
                </tr>

                @endif
                {{-- end if t->type != piping --}}
                @endforeach
                {{-- end foreach mcpt --}}
                @endforeach
                {{-- end foreach mcpwsm --}}

                {{-- TABLE PIPING --}}
                <tr class="no-border">
                    <th><b>Piping</b></th>
                    <th><b>Lebar</b>(')</th>
                    <th><b>Qty (PCS</b>)</th>
                    <th><b>Eff</b></th>
                    <th><b>Kons KG</b></th>
                    <th><b>Qty KG</b></th>
                    <th><b>Act KG</b></th>
                    <th><b>Kons Yd</b></th>
                    <th><b>Qty Yd</b></th>
                    <th><b>Act Yd</b></th>
                    <th><b>Kons Mtr</b></th>
                    <th><b>Qty Mtr</b></th>
                    <th><b>Act Mtr</b></th>
                </tr>
                @foreach ($mcpwsm as $wsm)
                @foreach ($mcpt as $t)
                @if ($t->type == "PIPING")


                <tr class="no-border">
                    <td>{{$t->component}}</td>
                    <td colspan="4">{{$t->fabricdesc}}</td>

                    <?php $totgramasi = 0.0; $amount = 0; ?>
                    @foreach ($mcpi as $pi)
                    @if ($pi->id_type == $t->id)

                    <?php $totgramasi += $pi->gramasi; $amount++ ?>

                    @endif
                    @endforeach
                    {{-- end foreach mcpd --}}
                    <td colspan="8">Gramasi : {{$totgramasi/$amount}}</td>
                </tr>
                <tr>
                    <td colspan="13" style="text-align: left; padding-left: 3%">{{$t->warna}}</td>
                </tr>

                {{-- inisialisasi variable total --}}
                <?php
                // pit = piping total
                    $tot_qty = 0.0;
                    $tot_eff = 0.0;
                    $tot_kon_skg = 0.0;
                    $tot_qty_kg = 0.0;
                    $tot_act_kg = 0.0;
                    $tot_kon_syd = 0.0;
                    $tot_qty_yd = 0.0;
                    $tot_act_yd = 0.0;
                    $tot_kon_smtr = 0.0;
                    $tot_qty_mtr = 0.0;
                    $tot_act_mtr = 0.0;

                    $i = 0;
                ?>

                @foreach ($mcpi as $pi)
                @if ($pi->id_type == $t->id)

                {{-- perhitungan piping: kons, qty, act --}}
                <?php
                    // consumption(konsumsi)
                    $kons_kg = (((($pi->panjang_m + $pi->tole_pjg_m) * ($pi->lebar_m + $pi->tole_lbr_m) * $pi->gramasi) / $pi->skala) * 12) / 1000;
                    $kons_yd = ((($pi->panjang_m + $pi->tole_pjg_m) / $pi->skala) / 0.914) * 12;
                    $kons_mtr = (($pi->panjang_m + $pi->tole_pjg_m) / $pi->skala) * 12;

                    // qty before tolerance
                    $be_qty_kg = sprintf("%.2f",($kons_kg)) * $pi->tot_ws_qty / 12;
                    $be_qty_yd = sprintf("%.2f",($kons_yd)) * $pi->tot_ws_qty / 12;
                    $be_qty_mtr = sprintf("%.2f",($kons_mtr)) * $pi->tot_ws_qty / 12;

                    // qty after tolerance
                    $af_qty_kg = sprintf("%.2f", ($be_qty_kg)) + (sprintf("%.2f", ($be_qty_kg)) * $pi->tolerance / 100);
                    $af_qty_yd = sprintf("%.2f", ($be_qty_yd)) + (sprintf("%.2f", ($be_qty_yd)) * $pi->tolerance / 100);
                    $af_qty_mtr = sprintf("%.2f", ($be_qty_mtr)) + (sprintf("%.2f", ($be_qty_mtr)) * $pi->tolerance / 100);

                    // actual value
                    $act_kg = sprintf("%.2f", ($af_qty_kg)) + (sprintf("%.2f", ($af_qty_kg)) * $pi->efisiensi / 100);
                    $act_yd = sprintf("%.2f", ($af_qty_yd)) + (sprintf("%.2f", ($af_qty_yd)) * $pi->efisiensi / 100);
                    $act_mtr = sprintf("%.2f", ($af_qty_mtr)) + (sprintf("%.2f", ($af_qty_mtr)) * $pi->efisiensi / 100);

                    // perhitungan total
                    $tot_qty += $pi->tot_ws_qty ;
                    $tot_eff += $pi->efisiensi;
                    $tot_kons_kg += $kons_kg;
                    $tot_qty_kg += $af_qty_kg;
                    $tot_act_kg = $act_kg;
                    $tot_kons_yd += $kons_yd;
                    $tot_qty_yd += $af_qty_yd;
                    $tot_act_yd = $act_yd;
                    $tot_kons_mtr += $kons_mtr;
                    $tot_qty_mtr += $af_qty_mtr;
                    $tot_act_mtr = $act_mtr;
                ?>

                <tr>
                    <td></td>
                    <td>{{sprintf("%.2f",($pi->lebar_m))}}</td>
                    <td>{{$pi->tot_ws_qty}}</td>
                    <td>{{sprintf("%.2f",($pi->efisiensi))}}%</td>
                    <td>{{sprintf("%.2f",($kons_kg))}}</td>
                    <td>{{sprintf("%.2f", ($af_qty_kg))}}</td>
                    <td>{{sprintf("%.2f", ($act_kg))}}</td>
                    <td>{{sprintf("%.2f",($kons_yd))}}</td>
                    <td>{{sprintf("%.2f", ($af_qty_yd))}}</td>
                    <td>{{sprintf("%.2f", ($act_yd))}}</td>
                    <td>{{sprintf("%.2f",($kons_mtr))}}</td>
                    <td>{{sprintf("%.2f", ($af_qty_mtr))}}</td>
                    <td>{{sprintf("%.2f", ($act_mtr))}}</td>
                </tr>

                @endif
                {{-- end if d->id_type == t->id  --}}

                {{-- menghitung row untuk pembagian rata-rata --}}
                <?php $i++; ?>

                @endforeach
                {{-- end foreach mcpi --}}
                <tr class="no-border bg-col">
                    <td></td>
                    <td></td>
                    <td>{{$tot_qty}}</td>
                    <td>{{sprintf("%.2f", ($tot_eff / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_kons_kg / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_kg / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_kg / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_kons_yd / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_yd / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_yd / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_kons_mtr / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_qty_mtr / $i))}}</td>
                    <td>{{sprintf("%.2f", ($tot_act_mtr / $i))}}</td>
                </tr>

                @endif
                {{-- end if t->type == piping --}}
                @endforeach
                {{-- end foreach mcpt --}}
                @endforeach
                {{-- end foreach mcpwsm --}}

            </table>
        </div>
        <div class="row">
            <div class="col-sm-6">Keterangan : {{$mcp->revisi_remark}}</div>
        </div>
    </div>

    <div class="container avoid-break">
        <div class="row">
            <div class="col">Tanggal : .............................</div>
            <div class="col"></div>
            <div class="col">Tanggal : .............................</div>
            <div class="col"></div>
            <div class="col">Tanggal : .............................</div>
        </div>
        <div class="row">
            <div class="col">Disusun Oleh :</div>
            <div class="col"></div>
            <div class="col">Diperiksa Oleh :</div>
            <div class="col"></div>
            <div class="col">Diperiksa Oleh :</div>
        </div>
        <div class="row" style="min-height: 70px;">
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col border-top border-dark text-center">ADM. CEK PROD</div>
            <div class="col"></div>
            <div class="col border-top border-dark text-center">MARKER</div>
            <div class="col"></div>
            <div class="col border-top border-dark text-center">MGR GARTECH</div>
        </div>
        <small>* Diterima Oleh : 1. Purchasing Kain 2. Follow up via email tanggal ...</small>
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
