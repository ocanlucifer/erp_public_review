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
    @foreach ($mcpwsm as $sm)
    @foreach ($mcpt as $type)
    @if ($type->id_wsheet == $sm->id)
    @foreach ($mcpi as $pi)
    @if ($pi->id_type == $type->id)

    <div class="container page-break">
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
                        <td>CM-MARK-005</td>
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

        <div class="row mt-3 justify-content-center">
            <h4>INTRUKSI PEMOTONGAN PIPING (cutting instruction of piping)</h4>
        </div>
        <hr style="border: 1px solid black; border-width: thin;" class="mt-4">

        <div class="row mt-3">
            <div class="col-md-2">NUMBER</div>
            <div class="col-md-3">: {{$mcp->number}}</div>
            <div class="col-md-2">PIPING UNTUK </div>
            <div class="col-md-3">: {{$pi->untuk}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">ORDER</div>
            <div class="col-md-3">: {{$mcp->order_name}}</div>
            <div class="col-md-2">UKURAN </div>
            <div class="col-md-3">: {{$pi->ukuran}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">STYLE</div>
            <div class="col-md-3">: {{$mcp->style}}</div>
            <div class="col-md-2">ARAH </div>
            <div class="col-md-3">: {{$pi->arah}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">BAHAN</div>
            <div class="col-md-3">:{{$type->fabricconst}}</div>
            <div class="col-md-2">COMPONEN </div>
            <div class="col-md-3">: {{$type->component}}</div>
        </div>
        <hr style="border: 1px solid black; border-width: thin;" class="mt-4">

        <div class="row">
            <div class="col-sm-3">KONSUMSI : 1</div>
            <div class="col-sm-3">WARNA : {{$type->warna}}</div>
            <div class="col-sm-3">COMBO : {{$sm->combo}}</div>
        </div>
        <hr style="border: 1px solid black; border-width: thin;" class="mt-4">

        <div class="row">
            <div class="col-sm-1">1 PCS</div>
            <div class="col-sm-2">= {{$pi->mp_pcs}} Meter</div>
            <div class="col-sm-2">= {{$pi->mp_pcs*1.09361}} Yard</div>
        </div>
        <div class="row">
            <div class="col-sm-1">Pola Asli</div>
            <div class="col-sm-2">= {{$pi->pola_asli}} Meter</div>
            <div class="col-sm-3">Jumlah Ampar = {{$pi->jml_ampar}}</div>
        </div>
        <div class="row">
            <div class="col-sm-1">Quantity</div>
            <div class="col-sm-2">= {{$sm->total_qty}} x {{sprintf("%.2f",$pi->mp_pcs*1.09361)}}</div>
            <div class="col-sm-3">= {{sprintf("%.2f",$sm->total_qty*$pi->mp_pcs*1.09361)}} Yard</div>
        </div>
        <div class="row">
            <div class="col-sm-1">P</div>
            <div class="col-sm-2">= {{$pi->panjang_m}} + {{$pi->tole_pjg_m}} mtr</div>
        </div>
        <div class="row">
            <div class="col-sm-1">L</div>
            <div class="col-sm-2">= {{$pi->lebar_m}} + {{$pi->tole_lbr_m}} mtr</div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">> {{$pi->skala}}/{{$pi->gramasi}} </div>
            <div class="col">=
                {{$kons_kg = sprintf("%.2f",(((($pi->panjang_m + $pi->tole_pjg_m) * ($pi->lebar_m + $pi->tole_lbr_m) * $pi->gramasi) / $pi->skala) * 12 / 1000))}}
                Kg/Dz
                =
                {{$kons_yd = sprintf("%.2f",(($pi->panjang_m + $pi->tole_pjg_m) / $pi->skala / 0.914 * 12))}}
                Yd/Dz
                = {{$kons_mtr = sprintf("%.2f",(($pi->panjang_m + $pi->tole_pjg_m) / $pi->skala * 12))}}
                Mtr/Dz
            </div>
        </div>
        <hr style="border: 1px solid black; border-width: thin;" class="mt-4">

        <div class="row">
            <div class="col-sm-1">Quantity</div>
            <div class="col-sm-2">= {{$sm->total_qty}} x {{sprintf("%.2f",$kons_kg)}} / 12</div>
            <div class="col-sm-2">{{$be_tole_kg = sprintf("%.2f",$kons_kg * $sm->total_qty / 12)}} +
                {{$pi->tolerance}} %
            </div>
            <div class="col-sm-2">= {{$af_tole_kg = sprintf("%.2f", $be_tole_kg + ($be_tole_kg * $pi->tolerance/100))}}
                Kg</div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">= {{$sm->total_qty}} x {{sprintf("%.2f",$kons_yd)}} / 12</div>
            <div class="col-sm-2">{{$be_tole_yd = sprintf("%.2f",$kons_yd * $sm->total_qty / 12)}} +
                {{$pi->tolerance}} %
            </div>
            <div class="col-sm-2">= {{$af_tole_yd = sprintf("%.2f", $be_tole_yd + ($be_tole_yd * $pi->tolerance/100))}}
                Yd</div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">= {{$sm->total_qty}} x {{sprintf("%.2f",$kons_mtr)}} / 12</div>
            <div class="col-sm-2">{{$be_tole_mtr = sprintf("%.2f",$kons_mtr * $sm->total_qty / 12)}} +
                {{$pi->tolerance}} %
            </div>
            <div class="col-sm-2">=
                {{$af_tole_mtr = sprintf("%.2f", $be_tole_mtr + ($be_tole_mtr *$pi->tolerance/100))}} Mtr</div>
        </div>

        <div style="background-color: lightgrey;">
            <hr style="border: 1px solid black; border-width: thin;" class="mt-4">
            <div class="row">
                <div class="col-sm-2">Untuk Warna</div>
                <div class="col-sm-3">: {{$type->warna}}</div>
                <div class="col-sm-2">= {{$af_tole_kg}} Kg</div>
                <div class="col-sm-2">= {{$af_tole_yd}} Yard</div>
                <div class="col-sm-2">= {{$af_tole_mtr}} Meter</div>
            </div>
            <hr style="border: 1px solid black; border-width: thin;" class="mt-4">
        </div>
    </div>
    @endif
    @endforeach
    @endif
    @endforeach
    @endforeach

    <div class="container">
        <div class="row mt-5">
            <div class="col">Tanggal : .............................</div>
            <div class="col"></div>
            <div class="col">Tanggal : .............................</div>
            <div class="col"></div>
            <div class="col">Tanggal : .............................</div>
        </div>
        <div class="row">
            <div class="col">Disusun Oleh</div>
            <div class="col"></div>
            <div class="col">Diperiksa Oleh</div>
            <div class="col"></div>
            <div class="col">Disetujui Oleh</div>
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
            <div class="col border-top border-dark">MGR GARTECH</div>
            <div class="col"></div>
            <div class="col border-top border-dark">GM MANUFAKTUR</div>
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
