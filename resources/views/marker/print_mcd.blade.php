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
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="row">Konsumsi Asli (Real Consumption)</div>
                <div class="row">
                    <div class="col-sm-4">Kode</div>
                    <div class="col-sm-8">: {{$mcd->kode}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Tanggal</div>
                    <div class="col-sm-8">: {{$mcd->created_at}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Order</div>
                    <div class="col-sm-8">: {{$mcd->markercal->order}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Style</div>
                    <div class="col-sm-8">: {{$mcd->markercal->style}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Kain</div>
                    <div class="col-sm-8">: {{$mcd->fabriccomp}}{{$mcd->fabricconst}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">A(PCS)</div>
                    <div class="col-sm-8">: {{$mcd->total_scale}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4">Size</div>
                    <div class="col-sm-8">: {{$mcd->size_name}}</div>
                </div>
            </div>
            <div class="col-sm-4">
                Komponen/PCS :
                <br>
                {{$mcd->remark}}
            </div>
            <div class="col-sm-4">
                Revisi : {{$mcd->revision}}<br>
                Revisi Remark : {{$mcd->revisionRemark}}<br>
                Gramasi :
                <?php
                $count = 1;
                foreach ($mcd->markercal_g as $mcg) {
                    if ($count !== 1) {
                        echo ',';
                    }

                    echo $mcg->gramasi;
                    $count++;
                }
                ?> <br>
                P = {{$mcd->pjg_m}} m + {{$mcd->tole_pjg_m}} m<br>
                L = {{$mcd->lbr_m}} m + {{$mcd->tole_lbr_m}} m<br>
                Kons Marker = (
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
                Kg/Pcs), (
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
                Yd/Pcs), (
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
                m/Pcs)
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                (Garment Technology)
            </div>
            <div class="col-sm-3">
                (GM Manufacturing)
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
