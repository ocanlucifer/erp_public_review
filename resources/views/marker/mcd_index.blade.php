@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/markercal')}}">Marker Calculation</a></li>
        <li class="breadcrumb-item active">Show</li>
    </ol>

    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $sukses; ?>
    </div>
    @endif
    @if ($error = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $error; ?>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row text-size-small">
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">Number</div>
                    <div class="col-sm-7">: {{$mc->mc_number}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Order name</div>
                    <div class="col-sm-7">: {{$mc->order}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Style name</div>
                    <div class="col-sm-7">: {{$mc->style}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Combo</div>
                    <div class="col-sm-7">: {{$mc->combo}}</div>
                    <br>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">Fabric Construct</div>
                    <div class="col-sm-7">: {{$mc->fabricconst}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Fabric Compost</div>
                    <div class="col-sm-7">: {{$mc->fabriccomp}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Global Revision</div>
                    <div class="col-sm-7">: {{$mc->revision}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Memo Instruction</div>
                    <div class="col-sm-7">: {{$mc->memo}}</div>
                    <br>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">State</div>
                    <div class="col-sm-7">: {{$mc->state}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Created at</div>
                    <div class="col-sm-7">: {{$mc->created_at}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Created By</div>
                    <div class="col-sm-7">: {{$mc->created_by}}</div>
                    <br>
                    @if ($mc->state == 'updated')
                    <div class="col-sm-5 font-weight-bold">Updated_by</div>
                    <div class="col-sm-7">: {{$mc->updated_by}}</div>
                    <br>
                    @elseif ($mc->state == 'confirmed')
                    <div class="col-sm-5 font-weight-bold">Confirmed All By</div>
                    <div class="col-sm-7">: {{$mc->updated_by}}</div>
                    <br>
                    @elseif ($mc->state == 'unconfirmed')
                    <div class="col-sm-5 font-weight-bold">Unconfirmed All By</div>
                    <div class="col-sm-7">: {{$mc->updated_by}}</div>
                    <br>
                    @endif

                </div>
            </div>
            <div class="row mt-20">
                <div class="col-sm-12">
                    <a id="btn_edit_mc" class="btn btn-primary btn-sm" href="#modal_index_edit" data-toggle="modal"
                        role="button" onclick="getDetail({{$mc->id}})">Edit</a>
                    <a class="btn btn-default btn-sm" href="/markercal" role="button">Back</a>
                    @if ($mc->state == 'created' || $mc->state == 'UNCONFIRMED')
                    <a id="btn_confirm_mc" onclick="mcConfirm({{$mc->id}})" class="btn btn-default btn-sm" href="#"
                        role="button">Confirm All</a>
                    @else
                    <a id="btn_unconfirm_mc" onclick="mcUnconfirm({{$mc->id}})" class="btn btn-default btn-sm" href="#"
                        role="button">Unconfirm All</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-20">
        <div class="card-header">
            <h4 style="margin: 0;">Marker Calculation Detail</h4>
        </div>
        <div class="card-body">
            <div class="row mb-10">
                <div class="col-sm-12">
                    <a href="#modal_detail_add" data-toggle="modal" class="btn btn-primary btn-sm"><i
                            class="icon-pencil"></i><small>New Detail</small></a>
                    <a href="/markercal/print/{{$mc->id}}" target="_blank" class="btn btn-success btn-sm"><i
                            class="icon-printer"></i><small>Print Calculations</small></a>
                </div>
            </div>

            <div class="row">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>#</th>
                        <th>Jenis Kain</th>
                        <th>Kain</th>
                        <th>Size</th>
                        <th>Lebar Kain</th>
                        <th>Kode</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Tanggal</th>
                        <th>Efisiensi</th>
                        <th>Perimeter</th>
                        <th>Total Scale</th>
                        <th>Revision</th>
                        <th>Tole Panjang</th>
                        <th>Tole Lebar</th>
                        <th>State</th>
                        <th>actions</th>
                    </tr>
                    <?php $no = 1; ?>
                    @foreach ($mcd as $mcd)
                    <tr onclick="rowMcd('{{$mcd->id}}')">
                        <td>{{$no}}</td>
                        <td>{{$mcd->fabric_type}}</td>
                        <td>{{$mcd->fabriccomp . " " . $mcd->fabricconst}}</td>
                        <td>{{$mcd->size_name}}</td>
                        <td>{{number_format(($mcd->lbr_m * 39.37),1) . '"'}}</td>
                        <td>{{$mcd->kode}}</td>
                        <td>{{$mcd->pjg_m}}</td>
                        <td>{{$mcd->lbr_m}}</td>
                        <td>{{$mcd->calculation_date}}</td>
                        <td>{{$mcd->efficiency}}</td>
                        <td>{{$mcd->perimeter}}</td>
                        <td>{{$mcd->total_scale}}</td>
                        <td>{{$mcd->revision}}</td>
                        <td>{{$mcd->tole_pjg_m}}</td>
                        <td>{{$mcd->tole_lbr_m}}</td>
                        <td>{{$mcd->state}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                </button>
                                <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                    @if ($mcd->state == "CONFIRMED")
                                    <a class="dropdown-item" href="/mcd/print/{{$mcd->id}}" target="_blank">Print</a>
                                    <a class="dropdown-item" href="/mcd/unconfirm/{{$mcd->id}}">Unconfirm</a>
                                    @else
                                    <a class="dropdown-item" target="_blank" href="/mcd/print/{{$mcd->id}}">Print</a>
                                    <a class="dropdown-item" href="#modal_detail_edit" data-toggle="modal"
                                        onclick="getDetail_d({{$mcd->id}})">Edit</a>
                                    <a class="dropdown-item" href="/mcd/delete/{{$mcd->id}}"
                                        onclick="return confirm('anda yakin akan menghapus data ini?');">Destroy</a>
                                    <a class="dropdown-item" href="/mcd/confirm/{{$mcd->id}}">Confirm</a>
                                    @endif

                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $no++; ?>
                    @endforeach
                </table>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="keterangan" class="font-weight-bolder">Keterangan</label>
                    <p>
                        <textarea class="form-control" cols="30" id="keterangan" name="keterangan" rows="8"
                            readonly></textarea>
                    </p>
                </div>
                <div class="col-sm-3">
                    <label for="keterangan_revisi" class="font-weight-bolder">Keterangan
                        Revisi</label>
                    <p>
                        <textarea class="form-control" cols="30" id="keterangan_revisi" name="keterangan_revisi"
                            rows="8" readonly></textarea>
                    </p>
                </div>
                <div class="col-sm-5">
                    <button href="#modal_gramasi_add" id="btn_modal_gramasi_add" data-toggle="modal"
                        class="btn btn-primary btn-sm mb-10" disabled><small>Add Gramasi</small></button>
                    <div class="row table-responseive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Gramasi</th>
                                    <th>Kg/dz</th>
                                    <th>Yd/dz</th>
                                    <th>m/dz</th>
                                    <th>actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_mcg">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- modal edit mc index--}}
<div class="row">
    <div id="modal_index_edit" class="modal fade">
        <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
            <div class="modal-content" id="background-body2" style="width: 150% !important;">
                <form action="" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class=" modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>Update Data Marker Calculation</strong></h6>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="e_id" id="e_id">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_number">Number</label>
                                    <input type="text" name="e_number" id="e_number" class="form-control"
                                        style="background-color: rgba(255,0,0,0.5);" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_style">Style Name</label>
                                    <input type="text" name="e_style" id="e_style" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_combo">Combo</label>
                                    <input type="text" name="e_combo" id="e_combo" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_numbering">Numbering</label>
                                    <input type="text" name="e_numbering" id="e_numbering" class="form-control" value=""
                                        style="background-color: rgba(255,0,0,0.5)" readonly>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="fabricconst_edit">Fabric Construct</label>
                                        <input type="hidden" id="id_fabricconst_edit" type="text"
                                            class="form-control @error('id_fabricconst_edit') is-invalid @enderror"
                                            name="id_fabricconst_edit" value="{{ old('id_fabricconst_edit') }}"
                                            autocomplete="off">
                                        <input id="fabricconst_edit" type="text"
                                            class="form-control @error('fabricconst_edit') is-invalid @enderror"
                                            name="fabricconst_edit" value="{{ old('fabricconst_edit') }}"
                                            autocomplete="off">
                                        <span>
                                            <div id="fabricconstlist_edit"></div>
                                        </span>

                                        @error('fabricconst_edit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_revision">Global Revision</label>
                                    <input type="number" name="e_revision" id="e_revision" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_order">*Order Name</label>
                                    <input type="text" name="e_order" id="e_order" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="fabriccomp_edit">Fabric Compost</label>
                                        <input type="hidden" id="id_fabriccomp_edit" type="text"
                                            class="form-control @error('id_fabriccomp_edit') is-invalid @enderror"
                                            name="id_fabriccomp_edit" value="{{ old('id_fabriccomp_edit') }}"
                                            autocomplete="off">
                                        <input id="fabriccomp_edit" type="text"
                                            class="form-control @error('fabriccomp_edit') is-invalid @enderror"
                                            name="fabriccomp_edit" value="{{ old('fabriccomp_edit') }}"
                                            autocomplete="off">
                                        <span>
                                            <div id="fabriccomplist_edit"></div>
                                        </span>

                                        @error('fabriccomp_edit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="e_memo">Memo Instruction</label>
                                    <input type="text" name="e_memo" id="e_memo" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="updateData()">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal add mc detail--}}
<div class="row">
    <div id="modal_detail_add" class="modal fade">
        <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
            <div class="modal-content" id="background-body2" style="width: 150% !important;">
                <form action="/mcd/create" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class=" modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>New Marker Calculation Detail</strong></h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="d_id_markercal" id="d_id_markercal" value="{{$mc->id}}">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="d_fabricconst">*Fabric Construct</label>
                                        <input type="hidden" id="d_id_fabricconst" type="text"
                                            class="form-control @error('d_id_fabricconst') is-invalid @enderror"
                                            name="d_id_fabricconst" value="{{ old('d_id_fabricconst') }}"
                                            autocomplete="off" required>
                                        <input id="d_fabricconst" type="text"
                                            class="form-control @error('d_fabricconst') is-invalid @enderror"
                                            name="d_fabricconst" value="{{ old('d_fabricconst') }}" autocomplete="off"
                                            required>
                                        <span>
                                            <div id="d_fabricconstlist"></div>
                                        </span>

                                        @error('d_fabricconst')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_pjg_m">*Panjang (Meter)</label>
                                    <input type="number" name="d_pjg_m" id="d_pjg_m" class="form-control" step="0.01"
                                        placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_tole_pjg_m">*Toleransi Panjang (Meter)</label>
                                    <input type="text" name="d_tole_pjg_m" id="d_tole_pjg_m" step="0.01"
                                        placeholder="0.00" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="d_fabriccomp">*Fabric Compost</label>
                                        <input type="hidden" id="d_id_fabriccomp" type="text"
                                            class="form-control @error('d_id_fabriccomp') is-invalid @enderror"
                                            name="d_id_fabriccomp" value="{{ old('d_id_fabriccomp') }}"
                                            autocomplete="off" required>
                                        <input id="d_fabriccomp" type="text"
                                            class="form-control @error('d_fabriccomp') is-invalid @enderror"
                                            name="d_fabriccomp" value="{{ old('d_fabriccomp') }}" autocomplete="off"
                                            required>
                                        <span>
                                            <div id="d_fabriccomplist"></div>
                                        </span>

                                        @error('d_fabriccomp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <label for="d_lbr_m"><b>*Lebar (meter)</b></label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" step="0.01" name="d_lbr_m" id="d_lbr_m"
                                        placeholder="0.00" required>
                                </div>
                                <div class="col-sm-6"><input class="form-control" type="number" step="0.01"
                                        name="d_lbr_inc" id="d_lbr_inc" readonly="" placeholder="inc"
                                        style="background-color: #FFB09F !important;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_tole_lbr_m">*Toleransi Lebar (Meter)</label>
                                    <input type="number" name="d_tole_lbr_m" id="d_tole_lbr_m" step="0.01"
                                        placeholder="0.00" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_kode">*Kode</label>
                                    <input type="text" name="d_kode" id="d_kode" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_efficiency">Efficiency</label>
                                    <input type="number" name="d_efficiency" id="d_efficiency" step="0.01"
                                        placeholder="0.00" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="d_color_name">Color Name</label>
                                        <input type="hidden" id="d_id_color_name" type="text"
                                            class="form-control @error('d_id_color_name') is-invalid @enderror"
                                            name="d_id_color_name" value="{{ old('d_id_color_name') }}"
                                            autocomplete="off">
                                        <input id="d_color_name" type="text"
                                            class="form-control @error('d_color_name') is-invalid @enderror"
                                            name="d_color_name" value="{{ old('d_color_name') }}" autocomplete="off">
                                        <span>
                                            <div id="d_color_namelist"></div>
                                        </span>

                                        @error('d_color_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_cal_date">Calculation Date</label>
                                    <input type="date" name="d_cal_date" id="d_cal_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_perimeter">Perimeter</label>
                                    <input type="number" name="d_perimeter" id="d_perimeter" class="form-control"
                                        step="0.01" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_revision">Revision</label>
                                    <input type="number" name="d_revision" id="d_revision" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_size_name">Size Name</label>
                                    <input type="text" name="d_size_name" id="d_size_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_total_scale">*Total Scale</label>
                                    <input type="number" name="d_total_scale" id="d_total_scale" class="form-control"
                                        step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_fabric_type">Fabric Type</label>
                                    <select name="d_fabric_type" id="d_fabric_type" class="form-control">
                                        <option value="fabric">FABRIC</option>
                                        <option value="keras">KERAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_pdf_marker">Pdf Marker</label>
                                    <input type="file" name="d_pdf_marker" id="d_pdf_marker" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_remark">Remark</label>
                                    <textarea name="d_remark" id="d_remark" cols="30" rows="10"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_revision_remark">Revision Remark</label>
                                    <textarea name="d_revision_remark" id="d_revision_remark" cols="30" rows="10"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="d_ordering">Ordering</label>
                                    <input type="number" name="d_ordering" id="d_ordering" class="form-control"
                                        placeholder="*dalam satuan meter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Marker Calculation Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal edit mc detail--}}
<div class="row">
    <div id="modal_detail_edit" class="modal fade">
        <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
            <div class="modal-content" id="background-body2" style="width: 150% !important;">
                <form action="/mcd/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class=" modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>Update Marker Calculation Detail</strong></h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="ed_id" id="ed_id">
                            <input type="hidden" name="ed_id_markercal" id="ed_id_markercal">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="d_fabricconst">*Fabric Construct</label>
                                        <input type="hidden" id="ed_id_fabricconst" type="text"
                                            class="form-control @error('ed_id_fabricconst') is-invalid @enderror"
                                            name="ed_id_fabricconst" value="{{ old('ed_id_fabricconst') }}"
                                            autocomplete="off" required>
                                        <input id="ed_fabricconst" type="text"
                                            class="form-control @error('ed_fabricconst') is-invalid @enderror"
                                            name="ed_fabricconst" value="{{ old('ed_fabricconst') }}" autocomplete="off"
                                            required>
                                        <span>
                                            <div id="ed_fabricconstlist"></div>
                                        </span>

                                        @error('ed_fabricconst')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_pjg_m">*Panjang (Meter)</label>
                                    <input type="number" name="ed_pjg_m" id="ed_pjg_m" class="form-control"
                                        placeholder="0.00" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_tole_pjg_m">*Toleransi Panjang (Meter)</label>
                                    <input type="text" name="ed_tole_pjg_m" id="ed_tole_pjg_m" class="form-control"
                                        placeholder="0.00" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="ed_fabriccomp">*Fabric Compost</label>
                                        <input type="hidden" id="ed_id_fabriccomp" type="text"
                                            class="form-control @error('ed_id_fabriccomp') is-invalid @enderror"
                                            name="ed_id_fabriccomp" value="{{ old('ed_id_fabriccomp') }}"
                                            autocomplete="off" required>
                                        <input id="ed_fabriccomp" type="text"
                                            class="form-control @error('ed_fabriccomp') is-invalid @enderror"
                                            name="ed_fabriccomp" value="{{ old('ed_fabriccomp') }}" autocomplete="off"
                                            required>
                                        <span>
                                            <div id="ed_fabriccomplist"></div>
                                        </span>

                                        @error('ed_fabriccomp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12">
                                    <label for="ed_lbr_m"><b>*Lebar (meter)</b></label>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" step="0.01" name="ed_lbr_m" id="ed_lbr_m"
                                        placeholder="0.00" required>
                                </div>
                                <div class="col-sm-6"><input class="form-control" type="number" step="0.01"
                                        name="ed_lbr_inc" id="ed_lbr_inc" readonly=""
                                        style="background-color: #FFB09F !important;" placeholder="inc">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_tole_lbr_m">*Toleransi Lebar (Meter)</label>
                                    <input type="number" step="0.01" name="ed_tole_lbr_m" id="ed_tole_lbr_m"
                                        class="form-control" placeholder="0.00" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_kode">*Kode</label>
                                    <input type="text" name="ed_kode" id="ed_kode" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_efficiency">Efficiency</label>
                                    <input type="number" name="ed_efficiency" id="ed_efficiency" class="form-control"
                                        step="0.01" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="ed_color_name">Color Name</label>
                                        <input type="hidden" id="ed_id_color_name" type="text"
                                            class="form-control @error('ed_id_color_name') is-invalid @enderror"
                                            name="ed_id_color_name" value="{{ old('ed_id_color_name') }}"
                                            autocomplete="off">
                                        <input id="ed_color_name" type="text"
                                            class="form-control @error('ed_color_name') is-invalid @enderror"
                                            name="ed_color_name" value="{{ old('ed_color_name') }}" autocomplete="off">
                                        <span>
                                            <div id="ed_color_namelist"></div>
                                        </span>

                                        @error('ed_color_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_cal_date">Calculation Date</label>
                                    <input type="date" name="ed_cal_date" id="ed_cal_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_perimeter">Perimeter</label>
                                    <input type="number" name="ed_perimeter" id="ed_perimeter" class="form-control"
                                        step="0.01" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_revision">Revision</label>
                                    <input type="number" name="ed_revision" id="ed_revision" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_size_name">Size Name</label>
                                    <input type="text" name="ed_size_name" id="ed_size_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_total_scale">*Total Scale</label>
                                    <input type="number" name="ed_total_scale" id="ed_total_scale" class="form-control"
                                        step="0.01" placeholder="0.00" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_fabric_type">Fabric Type</label>
                                    <select name="ed_fabric_type" id="ed_fabric_type" class="form-control">
                                        <option value="fabric">FABRIC</option>
                                        <option value="keras">KERAS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_pdf_marker">Pdf Marker</label>
                                    <input type="text" name="ed_pdf_marker" id="ed_pdf_marker" class="form-control"
                                        readonly>
                                    <input type="file" name="file_ed_pdf_marker" id="file_ed_pdf_marker"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_remark">Remark</label>
                                    <textarea name="ed_remark" id="ed_remark" cols="30" rows="10"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_revision_remark">Revision Remark</label>
                                    <textarea name="ed_revision_remark" id="ed_revision_remark" cols="30" rows="10"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="ed_ordering">Ordering</label>
                                    <input type="number" name="ed_ordering" id="ed_ordering" class="form-control"
                                        placeholder="*dalam satuan meter">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Marker Calculation Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal add gramasi--}}
<div class="row">
    <div id="modal_gramasi_add" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" id="background-body2">
                <form action="/mcg/create" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class=" modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>New Marker Calculation Grams</strong></h6>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="g_id_markercal_d" id="g_id_markercal_d">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="g_gramasi">Gramasi</label>
                                    <input type="number" min="0" name="g_gramasi" id="g_gramasi" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" name="add_gramasi" class="btn btn-primary">Create Marker
                                    Calculation Grams</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- modal edit gramasi --}}
<div class="row">
    <div id="modal_gramasi_edit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content" id="background-body2">
                <form action="/mcg/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class=" modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>Edit Marker Calculation Grams</strong></h6>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="eg_id_markercal_g" id="eg_id_markercal_g">
                        <input type="hidden" name="eg_id_markercal_d" id="eg_id_markercal_d">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="eg_gramasi">Gramasi</label>
                                    <input type="number" min="0" name="eg_gramasi" id="eg_gramasi" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" name="edit_gramasi" class="btn btn-primary">Update Marker
                                    Calculation Grmas</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#fabricconst').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabricconst') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#fabricconstlist').fadeIn();
                            $('#fabricconstlist').html(data);
                            } else {
                            $('#fabricconstlist').fadeOut();
                            $('#fabricconstlist').empty();
                            $('#id_fabricconst').val('');
                            $('#fabricconst').val('');
                        }
                    }
                });
            }
        });
        $('#fabriccomp').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                var id_fabricconst = $('#id_fabricconst').val();
                $.ajax({
                    url:"{{ route('autocomplete.fabriccomp') }}",
                    method:"POST",
                    data:{query:query, _token:_token, id_fabricconst:id_fabricconst},
                    success:function(data){
                        if (data!='') {
                            $('#fabriccomplist').fadeIn();
                            $('#fabriccomplist').html(data);
                            } else {
                            $('#fabriccomplist').fadeOut();
                            $('#fabriccomplist').empty();
                            $('#id_fabriccomp').val('')
                            $('#fabriccomp').val('');
                        }
                    }
                });
            }
        });
        $('#fabricconst_edit').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabricconst_edit') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#fabricconstlist_edit').fadeIn();
                            $('#fabricconstlist_edit').html(data);
                            } else {
                            $('#fabricconstlist_edit').fadeOut();
                            $('#fabricconstlist_edit').empty();
                            $('#id_fabricconst_edit').val('');
                            $('#fabricconst_edit').val('');
                        }
                    }
                });
            }
        });
        $('#fabriccomp_edit').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                var id_fabricconst_edit = $('#id_fabricconst_edit').val();
                $.ajax({
                    url:"{{ route('autocomplete.fabriccomp_edit') }}",
                    method:"POST",
                    data:{query:query, _token:_token, id_fabricconst_edit:id_fabricconst_edit},
                    success:function(data){
                        if (data!='') {
                            $('#fabriccomplist_edit').fadeIn();
                            $('#fabriccomplist_edit').html(data);
                            } else {
                            $('#fabriccomplist_edit').fadeOut();
                            $('#fabriccomplist_edit').empty();
                            $('#id_fabriccomp_edit').val('')
                            $('#fabriccomp_edit').val('');
                        }
                    }
                });
            }
        });
        $('#d_fabricconst').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.d_fabricconst') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#d_fabricconstlist').fadeIn();
                            $('#d_fabricconstlist').html(data);
                            } else {
                            $('#d_fabricconstlist').fadeOut();
                            $('#d_fabricconstlist').empty();
                            $('#d_id_fabricconst').val('');
                            $('#d_fabricconst').val('');
                        }
                    }
                });
            }
        });
        $('#d_fabriccomp').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                var d_id_fabricconst = $('#d_id_fabricconst').val();
                $.ajax({
                    url:"{{ route('autocomplete.d_fabriccomp') }}",
                    method:"POST",
                    data:{query:query, _token:_token, d_id_fabricconst:d_id_fabricconst},
                    success:function(data){
                        if (data!='') {
                            $('#d_fabriccomplist').fadeIn();
                            $('#d_fabriccomplist').html(data);
                            } else {
                            $('#d_fabriccomplist').fadeOut();
                            $('#d_fabriccomplist').empty();
                            $('#d_id_fabriccomp').val('')
                            $('#d_fabriccomp').val('');
                        }
                    }
                });
            }
        });
        $('#ed_fabricconst').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.ed_fabricconst') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#ed_fabricconstlist').fadeIn();
                            $('#ed_fabricconstlist').html(data);
                            } else {
                            $('#ed_fabricconstlist').fadeOut();
                            $('#ed_fabricconstlist').empty();
                            $('#ed_id_fabricconst').val('');
                            $('#ed_fabricconst').val('');
                        }
                    }
                });
            }
        });
        $('#ed_fabriccomp').keyup(function(){
            var query = $(this).val();
            if(query != ''){
                var _token = $('input[name="_token"]').val();
                var ed_id_fabricconst = $('#ed_id_fabricconst').val();
                $.ajax({
                    url:"{{ route('autocomplete.ed_fabriccomp') }}",
                    method:"POST",
                    data:{query:query, _token:_token, ed_id_fabricconst:ed_id_fabricconst},
                    success:function(data){
                        if (data!='') {
                            $('#ed_fabriccomplist').fadeIn();
                            $('#ed_fabriccomplist').html(data);
                            } else {
                            $('#ed_fabriccomplist').fadeOut();
                            $('#ed_fabriccomplist').empty();
                            $('#ed_id_fabriccomp').val('')
                            $('#ed_fabriccomp').val('');
                        }
                    }
                });
            }
        });
        $('#d_color_name').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.color') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#d_color_namelist').fadeIn();
                            $('#d_color_namelist').html(data);
                            } else {
                            $('#d_color_namelist').fadeOut();
                            $('#d_color_namelist').empty();
                            $('#d_id_color_name').val('');
                            $('#d_color_name').val('');
                        }
                    }
                });
            }
        });
        $('#ed_color_name').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.color_form') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#ed_color_namelist').fadeIn();
                            $('#ed_color_namelist').html(data);
                            } else {
                            $('#ed_color_namelist').fadeOut();
                            $('#ed_color_namelist').empty();
                            $('#ed_id_color_name').val('');
                            $('#ed_color_name').val('');
                        }
                    }
                });
            }
        });
        $('#d_lbr_m').keyup(function(){
            var lebar_m = $(this).val();
            var lebar_inc = (lebar_m * 39.3701).toFixed(2);
            $('#d_lbr_inc').val(lebar_inc);
        })
        $('#ed_lbr_m').keyup(function(){
            var lebar_m = $(this).val();
            var lebar_inc = (lebar_m * 39.3701).toFixed(2);
            $('#ed_lbr_inc').val(lebar_inc);
        })
    });

    function mcConfirm(id){
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/markercal/confirm/{id}',
            type: 'POST',
            data: {id: id, _token: _token},
            dataType: 'JSON',
            success: function(res){
                window.location.href = '{{ url("/mcd") }}'+'/'+id;
            }
        });
    }

    function mcUnconfirm(id){
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/markercal/unconfirm/{id}',
            type: 'POST',
            data: {id: id, _token: _token},
            dataType: 'JSON',
            success: function(res){
                window.location.href = '{{ url("/mcd") }}'+'/'+id;
            }
        });
    }

    function getDetail(mc_id){
        var id = mc_id;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/markercal/edit/{id}',
            type: 'POST',
            data: {id: id, _token: _token},
            dataType: 'json',
            success: function(res) {
                console.log(res);
                $('input[name="e_id"]').val(res.id);
                $('input[name="e_number"]').val(res.mc_number);
                $('input[name="e_style"]').val(res.style);
                $('input[name="e_combo"]').val(res.combo);
                $('input[name="e_numbering"]').val(res.numbering);
                $('input[name="fabricconst_edit"]').val(res.fabricconst);
                $('input[name="e_revision"]').val(res.revision);
                $('input[name="e_order"]').val(res.order);
                $('input[name="fabriccomp_edit"]').val(res.fabriccomp);
                $('input[name="e_memo"]').val(res.memo);
            }
        });
    }

    function updateData(){
        var id = $("[name= 'e_id']").val();
        var mc_number = $("[name= 'e_number']").val();
        var style = $("[name= 'e_style']").val();
        var combo = $("[name= 'e_combo']").val();
        var numbering = $("[name= 'e_numbering']").val();
        var fabricconst_edit = $("[name= 'fabricconst_edit']").val();
        var revision = $("[name= 'e_revision']").val();
        var order = $("[name= 'e_order']").val();
        var fabriccomp_edit = $("[name= 'fabriccomp_edit']").val();
        var memo = $("[name= 'e_memo']").val();
        var _token = $('input[name="_token"]').val();

         $.ajax({
            url: '/markercal/update/' ,
            type: 'POST',
            data: {
                id: id,
                mc_number: mc_number,
                style: style,
                combo: combo,
                numbering: numbering,
                fabricconst: fabricconst_edit,
                revision: revision,
                order: order,
                fabriccomp: fabriccomp_edit,
                memo: memo,
                _token: _token
            }
        }).done(function (data) {
                $('#modal_edit').modal('hide');
                window.location.href = '{{ url("/mcd") }}'+'/'+id;
        }).fail(function (msg) {
            alert('Gagal menampilkan data, silahkan refresh halaman.');
        });
    }

    function rowMcd(id_mcd){
        var _token = $('input[name="_token"]').val();
        var id_mcd = id_mcd;

        $.ajax({
            url: '/mcd/edit/{id}',
            type: 'POST',
            data: {id: id_mcd, _token: _token},
            dataType: 'json',
            success: function(res) {
                console.log(res.remark);
                console.log(res.revisionRemark);
                $("#keterangan").val(res.remark);
                $("#keterangan_revisi").val(res.revisionRemark);
            }
        });

        $("#g_id_markercal_d").val(id_mcd);
        $("#btn_modal_gramasi_add").prop('disabled', false);

        $.ajax({
            url: '/mcd/get_markercal_g',
            method: 'POST',
            data: {id_mcd: id_mcd, _token: _token},
            dataType: 'JSON',
            success: function(res){
                row = '';
                for(var i=0; i<res.length; i++){
                    row += '<tr>'+
                    '<td>'+(res[i].gramasi)+'</td>'+
                    '<td>'+res[i].kgdz.toFixed(2)+'</td>'+
                    '<td>'+res[i].yddz.toFixed(2)+'</td>'+
                    '<td>'+res[i].mddz.toFixed(2)+'</td>'+
                    '<td><a href="#modal_gramasi_edit" onclick="getDetailMcg('+res[i].id_markercal_g+')" data-toggle="modal" class="mr-10"><i class="icon-pencil"></i><small>Edit</small></a><a href="/mcg/delete/'+res[i].id_markercal_g+'" onclick="return confirm(`Anda yakin untuk menghapus item ini?`)"><i class="icon-trash"></i><small>Del</small></a>'+
                    '</td>'+
                    '</tr>'
                }

                $('#tbody_mcg').html(row);
            }
        });
    }

    function getDetail_d(mcd_id){
        var id = mcd_id;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/mcd/edit/'+id+'',
            type: 'POST',
            data: {id:id, _token:_token},
            dataType: 'json',
            success: function(res){
                console.log(res);
                var lebar_inc = (res.lbr_m * 39.3701).toFixed(2);

                $('input[name="ed_id"]').val(res.id);
                $('input[name="ed_id_markercal"]').val(res.id_markercal);
                $('input[name="ed_kode"]').val(res.kode);
                $('input[name="ed_cal_date"]').val(res.calculation_date);
                $('input[name="ed_color_name"]').val(res.color_name);
                $('input[name="ed_efficiency"]').val(res.efficiency);
                $('input[name="ed_fabricconst"]').val(res.fabricconst);
                $('input[name="ed_fabriccomp"]').val(res.fabriccomp);
                $('input[name="ed_lbr_m"]').val(res.lbr_m);
                $('input[name="ed_lbr_inc"]').val(lebar_inc);
                $('input[name="ed_ordering"]').val(res.ordering);
                $('input[name="ed_pdf_marker"]').val(res.pdf_marker);
                $('input[name="ed_peerimeter"]').val(res.perimeter);
                $('input[name="ed_pjg_m"]').val(res.pjg_m);
                $('#ed_remark').val(res.remark);
                $('#ed_revision_remark').val(res.revision);
                $('input[name="ed_revisionRemark"]').val(res.revision_remark);
                $('input[name="ed_size_name"]').val(res.size_name);
                $('input[name="ed_tole_lbr_m"]').val(res.tole_lbr_m);
                $('input[name="ed_tole_pjg_m"]').val(res.tole_pjg_m);
                $('input[name="ed_total_scale"]').val(res.total_scale);

                const fabric_type = ["fabric", "keras"];
                for(var i=0; i<fabric_type.length;i++){
                    var selected1 = '';
                    var selected2 = '';

                    if(fabric_type[i] == 'fabric'){
                        selected1 = 'selected';
                    } else {
                        selected2 = 'selected';
                    }
                }

                row = '<option value="fabric"'+selected1+'>FABRIC</option>' +'<option value="keras"'+selected2+'>KERAS</option>';
                $('#ed_fabric_type').html(row);
            }
        });
    }

    function getDetailMcg(id_mcg){
        var id_mcg = id_mcg;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/mcg/edit',
            type: 'POST',
            data: {id_mcg: id_mcg, _token: _token},
            dataType: 'json',
            success: function(res) {
                console.log(res);

                $('#eg_id_markercal_g').val(res.id_markercal_g)
                $('#eg_id_markercal_d').val(res.id_markercal_d)
                $('#eg_gramasi').val(res.gramasi);
            }
        });
    }

    function pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabricconst').val($('#id_fabricconst'+ls).text());
        $('#fabricconst').val($('#fabricconst'+ls).text());
        $('#fabricconstlist').fadeOut();
    }
    function pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabriccomp').val($('#id_fabriccomp'+ls).text());
        $('#fabriccomp').val($('#fabriccomp'+ls).text());
        $('#fabriccomplist').fadeOut();
    }
    function pilihFabricconstructedit($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabricconst_edit').val($('#id_fabricconst_edit'+ls).text());
        $('#fabricconst_edit').val($('#fabricconst_edit'+ls).text());
        $('#fabricconstlist_edit').fadeOut();
    }
    function pilihFabriccompostedit($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabriccomp_edit').val($('#id_fabriccomp_edit'+ls).text());
        $('#fabriccomp_edit').val($('#fabriccomp_edit'+ls).text());
        $('#fabriccomplist_edit').fadeOut();
    }
    function d_pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#d_id_fabricconst').val($('#d_id_fabricconst'+ls).text());
        $('#d_fabricconst').val($('#d_fabricconst'+ls).text());
        $('#d_fabricconstlist').fadeOut();
    }
    function d_pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#d_id_fabriccomp').val($('#d_id_fabriccomp'+ls).text());
        $('#d_fabriccomp').val($('#d_fabriccomp'+ls).text());
        $('#d_fabriccomplist').fadeOut();
    }
    function ed_pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#ed_id_fabricconst').val($('#ed_id_fabricconst'+ls).text());
        $('#ed_fabricconst').val($('#ed_fabricconst'+ls).text());
        $('#ed_fabricconstlist').fadeOut();
    }
    function ed_pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#ed_id_fabriccomp').val($('#ed_id_fabriccomp'+ls).text());
        $('#ed_fabriccomp').val($('#ed_fabriccomp'+ls).text());
        $('#ed_fabriccomplist').fadeOut();
    }
    function pilihColor($ls){
        var ls = $ls;
        $('#d_id_color_name').val($('#code_col'+ls).text());
        $('#d_color_name').val($('#col'+ls).text());
        $('#d_color_namelist').fadeOut();
    }
    function pilihColor_form($ls){
        var ls = $ls;
        $('#ed_id_color_name').val($('#code_col'+ls).text());
        $('#ed_color_name').val($('#col'+ls).text());
        $('#ed_color_namelist').fadeOut();
    }

    function getDatas(page){
        keyword = $('#keyword').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url : '{{URL::to("/markercal")}}?page=' + page,
            type : 'get',
            dataType: 'json',
            data:{'keyword':keyword ,'_token':_token}
        }).done(function (data) {
            $('tbody').html(data);
            location.hash = page;
        }).fail(function (msg) {
            alert('Gagal menampilkan data, silahkan refresh halaman.');
        });
    }

    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });

    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getDatas(page);
            }
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(e) {
            var url = $(this).attr('href');
            getDatas($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });
</script
