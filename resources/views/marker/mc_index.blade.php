@extends('layouts.app')

@section('content')
<div class="">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Marker Calculations</li>
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
        <div class="card-header">
            Marker Calculations
        </div>
        <div class="card-body">
            <div align="right">
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    New Data</a>
            </div>

            <div class="table table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <th>Number</th>
                            <th>Order Name</th>
                            <th>Style Name</th>
                            <th>Combo</th>
                            <th>Fabric Construct</th>
                            <th>Fabric Compost</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="text" class="form-control" onkeyup="getDatas()" name="keyword" id="keyword"
                                    placeholder="Search MC Number/Order Name" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <tbody id="view">
                        @include('marker.mc_list')
                    </tbody>
                    </thead>
                </table>
            </div>

        </div>
    </div>

    {{-- modal --}}
    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
                <div class="modal-content" id="background-body2" style="width: 150% !important;">
                    <form action="/markercal/create" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Data Marker Calculation</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="number">Number</label>
                                        <input type="text" name="number" id="number" class="form-control"
                                            style="background-color: rgba(255,0,0,0.5);" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="style">Style Name</label>
                                        <input type="text" name="style" id="style" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="combo">Combo</label>
                                        <input type="text" name="combo" id="combo" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="numbering">Numbering</label>
                                        <?php $yearnow = date('Y'); ?>
                                        <input type="text" name="numbering" id="numbering" class="form-control"
                                            value="{{'Marker Calculation ' . $yearnow}}"
                                            style="background-color: rgba(255,0,0,0.5)" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabricconst">Fabric Construct</label>
                                            <input type="hidden" id="id_fabricconst" type="text"
                                                class="form-control @error('id_fabricconst') is-invalid @enderror"
                                                name="id_fabricconst" value="{{ old('id_fabricconst') }}"
                                                autocomplete="off">
                                            <input id="fabricconst" type="text"
                                                class="form-control @error('fabricconst') is-invalid @enderror"
                                                name="fabricconst" value="{{ old('fabricconst') }}" autocomplete="off">
                                            <span>
                                                <div id="fabricconstlist"></div>
                                            </span>

                                            @error('fabricconst')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="revision">Global Revision</label>
                                        <input type="number" name="revision" id="revision" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="order">*Order Name</label>
                                        <input type="text" name="order" id="order" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabriccomp">Fabric Compost</label>
                                            <input type="hidden" id="id_fabriccomp" type="text"
                                                class="form-control @error('id_fabriccomp') is-invalid @enderror"
                                                name="id_fabriccomp" value="{{ old('id_fabriccomp') }}"
                                                autocomplete="off">
                                            <input id="fabriccomp" type="text"
                                                class="form-control @error('fabriccomp') is-invalid @enderror"
                                                name="fabriccomp" value="{{ old('fabriccomp') }}" autocomplete="off">
                                            <span>
                                                <div id="fabriccomplist"></div>
                                            </span>

                                            @error('fabriccomp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="memo">Memo Instruction</label>
                                        <input type="text" name="memo" id="memo" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit --}}
    <div class="row">
        <div id="modal_edit" class="modal fade">
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
                                        <?php $yearnow = date('Y'); ?>
                                        <input type="text" name="e_numbering" id="e_numbering" class="form-control"
                                            value="{{'Marker Calculation ' . $yearnow}}"
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
                            <button type="button" class="btn btn-primary" onclick="updateData()">Submit</button>
                        </div>
                    </form>
                </div>
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
    });

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

    function getDetail(mc_id)
    {
        var id = mc_id;
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/markercal/edit/{id}',
            type: 'POST',
            data: {id: id, _token: _token},
            dataType: 'json',
            success: function(res) {
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
</script>
