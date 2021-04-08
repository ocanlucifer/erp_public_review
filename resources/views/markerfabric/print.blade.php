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

    <style>
        @media print {
            body {
                size: 21cm 29.7cm;
                /* margin: 30mm 45mm 30mm 45mm; */
                margin-top: 30mm;
            }
        }

        .logo-teo {
            max-width: 75%;
            max-height: auto;
            vertical-align: middle;
        }

        .name-teo {
            padding-left: 0em;
        }

        /* h1 {
            font-weight: bold;
            font-size: 20pt;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .text-center {
            text-align: center;
        } */
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
                        alt=""></div>
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
                            <div class="row"><small>No.Dokumen : {{$document->no_document}}</small></div>
                            <div class="row"><small>Tanggal Berlaku : {{$document->date}}</small></div>
                            <div class="row"><small>Revisi : {{$document->revision}}</small></div>
                            <div class="row"><small>Halaman : {{$document->page}}</small></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 justify-content-center">
                <h4>REKAP KONSUMSI KAIN MARKER PRODUKSI</h4>
            </div>

            <div class="row mt-3">
                <div class="col-md-6 font-weight-bold">Order : {{$marker->nama_marker}}</div>
            </div>
            <div class="row">
                <div class="col-md-6 font-weight-bold">Style : {{$marker->style}}</div>
            </div>

            <?php $no=0; ?>
            <?php $i=0; ?>
            @foreach ($markerfab as $mkf)
            <?php $j=0; ?>
            <?php $jml_width; $jml_quantity = 0; $jml_consumption=0; $jml_efficiency=0; $jml_qty_unit=0; $jml_act_unit=0; ?>

            <div class="row mt-3 table-responsive">
                <table class="table table-bordered ">
                    <thead class="text-center">
                        <th>{{$mkf->marker_type}}</th>
                        <th>Lebar (*)</th>
                        <th>QTY (PCS)</th>
                        <th>KONS</th>
                        <th>EFF (%)</th>
                        <th>QTY UNIT</th>
                        <th>ACT UNIT</th>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bold">
                            <td colspan="7">{{$markerfab[$no]['marker_type']}},
                                {{$markerfab[$no]['description']}}, Gramasi : {{$markerfab[$no]['gramasi']}}</td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>{{$markerfab[$no]['name']}}</td>
                        </tr>

                        <?php markerdesc: ?>
                        <?php $jml_j = count($markerdesc[$i]); ?>

                        <tr class="text-center">
                            <td></td>
                            <td>{{$markerdesc[$i][$j]['width']}}</td>
                            <td>{{$markerdesc[$i][$j]['quantity']}}</td>
                            <td>{{$markerdesc[$i][$j]['consumption']}}</td>
                            <td>{{$markerdesc[$i][$j]['efficiency']}}</td>
                            <td>{{$markerdesc[$i][$j]['qty_unit']}}</td>
                            <td>{{$markerdesc[$i][$j]['act_unit']}}</td>
                        </tr>

                        <?php
                        $jml_quantity += $markerdesc[$i][$j]['quantity'];
                        $jml_consumption += $markerdesc[$i][$j]['consumption'];
                        $jml_efficiency += $markerdesc[$i][$j]['efficiency'];
                        $jml_qty_unit += $markerdesc[$i][$j]['qty_unit'];
                        $jml_act_unit += $markerdesc[$i][$j]['act_unit'];
                        ?>

                        <?php
                        $j++;
                        if ($j < $jml_j) {
                            goto markerdesc;
                        }
                        ?>

                        <tr class="text-center font-weight-bold">
                            <td></td>
                            <td></td>
                            <td>{{$jml_quantity}}</td>
                            <td>{{$jml_consumption}}</td>
                            <td>{{$jml_efficiency}}</td>
                            <td>{{$jml_qty_unit}}</td>
                            <td>{{$jml_act_unit}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php $no++; ?>
            <?php $i++; ?>
            @endforeach
            <hr class="mb-20">
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
                <div class="col border-top border-dark">Adm. Cek Produksi</div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col border-top border-dark">GARTECH</div>
                <div class="col"></div>
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
