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

    <style type="text/css" media="print"></style>

    <style type="text/css" media="print">
        <style type="text/css">body {
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
                        <td>CM-MARK-012</td>
                    </tr>
                    <tr>
                        <td>Tanggal Berlaku</td>
                        <td>:</td>
                        <td>29-12-2014</td>
                    </tr>
                    <tr>
                        <td>Revisi</td>
                        <td>:</td>
                        <td>
                            @if ($mc->revision == '')
                            0
                            @else
                            {{$mc->revision}}
                            @endif
                        </td>
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
            <h6 class="font-weight-bold">DATA KONSUMSI PERHITUNGAN SIZE TENGAH</h6>
        </div>

        <div class="row mt-3">
            <div class="col-sm-1">NUMBER</div>
            <div class="col-sm-2 font-weight-normal">: {{$mc->number}} </div>
            <div class="col-sm-1">STYLE</div>
            <div class="col-sm-2 font-weight-normal">: {{$mc->style}}</div>
        </div>
        <div class="row">
            <div class="col-sm-1">TANGGAL</div>
            <div class="col-sm-2 font-weight-normal">: {{$mc->created_at}}</div>
            <div class="col-sm-1">REVISI</div>
            <div class="col-sm-2 font-weight-normal">: {{$mc->revision}}</div>
        </div>
        <div class="row">
            <div class="col-sm-1">ORDER</div>
            <div class="col-sm-2 font-weight-normal">: {{$mc->order}}</div>
            <div class="col-sm-1"></div>
            <div class="col-sm-2"></div>
        </div>

        <div class="row">
            <div class="row mt-3 table-responsive">
                <table class="font-weight-normal">
                    <tr>
                        <th>No.</th>
                        <th>KOMPONEN/MARKER</th>
                        <th>WARNA</th>
                        <th>JENIS KAIN</th>
                        <th>GRAM</th>
                        <th>LEBAR</th>
                        <th>SIZE</th>
                        <th>Kg/Pcs</th>
                        <th>Yard/Pcs</th>
                        <th>Meter/Pcs</th>
                        <th>EFISIENSI</th>
                    </tr>

                    @foreach ($markercal_d as $mcd)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$mcd->remark}}</td>
                        <td>{{$mcd->color_name}}</td>
                        <td>{{$mcd->fabric_type}}</td>
                        <td>
                            <?php
                                $count = 1;
                                foreach ($mcd->markercal_g as $mcg) {
                                    if ($count !== 1) {
                                        echo ',';
                                    }

                                    echo $mcg->gramasi;
                                    $count++;
                                }
                                ?>
                        </td>
                        <td>{{number_format($mcd->lbr_m * 39.1701,2)}}</td>
                        <td>{{$mcd->size_name}}</td>
                        <td>
                            <?php
                                $count = 1;
                                foreach ($mcd->markercal_g as $mcg) {
                                    if ($count !== 1) {
                                        echo ',';
                                    }

                                    echo $mcg->kgdz;
                                    $count++;
                                }
                                ?>
                        </td>
                        <td>
                            <?php
                                $count = 1;
                                foreach ($mcd->markercal_g as $mcg) {
                                    if ($count !== 1) {
                                        echo ',';
                                    }

                                    echo $mcg->yddz;
                                    $count++;
                                }
                                ?>
                        </td>
                        <td>
                            <?php
                                $count = 1;
                                foreach ($mcd->markercal_g as $mcg) {
                                    if ($count !== 1) {
                                        echo ',';
                                    }

                                    echo $mcg->mddz;
                                    $count++;
                                }
                                ?>
                        </td>
                        <td>{{$mcd->efficiency}} %</td>
                    </tr>
                    @endforeach
                </table>

                Keterangan : <br>
                <span class="font-weight-normal">{{$mc->memo}}</span>
            </div>
        </div>

        <div class="container avoid-break">
            <div class="row mt-3">
                <div class="col">Tanggal : .............................</div>
                <div class="col"></div>
                <div class="col">Tanggal : .............................</div>
                <div class="col"></div>
                <div class="col">Tanggal : .............................</div>
            </div>
            <div class="row">
                <div class="col">Dibuat Oleh :</div>
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
            <div class="row mb-3">
                <div class="col border-top border-dark text-center">ADM. MARKER</div>
                <div class="col"></div>
                <div class="col border-top border-dark text-center">MARKER</div>
                <div class="col"></div>
                <div class="col border-top border-dark text-center">MGR. GARMENT TECH.</div>
            </div>

            * Diterima Oleh : 1. Purchasing Kain 2. Follow up via email tanggal ...
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
