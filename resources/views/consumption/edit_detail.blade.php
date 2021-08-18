<div class="form-group">
    <div class="input-group">
        <label for="fabric_construct">Fabric Construct</label>
        <input type="hidden" id="id_fabric_construct_edit" type="text"
            class="form-control @error('id_fabric_construct') is-invalid @enderror"
            name="id_fabric_construct" value="{{$cons_detail->id_fab_cons}}" required
            autocomplete="off">
        <input id="fabric_construct_edit" type="text"
            class="form-control @error('fabric_construct') is-invalid @enderror"
            name="fabric_construct" value="{{$cons_detail->fabricconst['name']}}" required
            autocomplete="off">
        <span>
            <div id="id_fabric_constructlist_edit"></div>
        </span>

        @error('id_fabric_construct')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <label for="fabric_compost">Fabric Compost</label>
        <input type="hidden" id="id_fabric_compost_edit" type="text"
            class="form-control @error('id_fabric_compost') is-invalid @enderror"
            name="id_fabric_compost" value="{{$cons_detail->id_fab_comp}}" required
            autocomplete="off">
        <input id="fabric_compost_edit" type="text"
            class="form-control @error('fabric_compost') is-invalid @enderror"
            name="fabric_compost" value="{{$cons_detail->fabriccomp['name']}}" required
            autocomplete="off">
        <span>
            <div id="id_fabric_compostlist_edit"></div>
        </span>

        @error('id_fabric_compost')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
<div class="form-group">
    <div class="input-group">
        <label for="fabric_description">Fabric Descripstion</label>
        <input type="text" name="description" id="fabric_description"
            class="form-control" placeholder="Fabric Description" value="{{$cons_detail->description}}">
    </div>
</div>
<br>
<input type="hidden" name="id_consumption" value="{{$cons_detail->id_consumption}}">
<input type="hidden" name="id_detail" value="{{$cons_detail->id}}">
<input type="hidden" name="jenis" value="{{$cons_detail->jenis}}">

<script type="text/javascript">
  $(document).ready(function(){
    $('#fabric_construct_edit').keyup(function(){
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
                        $('#id_fabric_constructlist_edit').fadeIn();
                        $('#id_fabric_constructlist_edit').html(data);
                    } else {
                        $('#id_fabric_constructlist_edit').fadeOut();
                        $('#id_fabric_constructlist_edit').empty();
                        $('#id_fabric_construct_edit').val('');
                        $('#fabric_construct_edit').val('');
                    }
                }
            });
        }
    });
    $('#fabric_compost_edit').keyup(function(){
        var query = $(this).val();
        var fabricconstruct_id = $('#id_fabric_construct_edit').val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.fabriccomp_edit') }}",
            method:"POST",
            data:{query:query, id_fabricconst_edit:fabricconstruct_id, _token:_token},
            success:function(data){
                if (data!='') {
                    $('#id_fabric_compostlist_edit').fadeIn();
                    $('#id_fabric_compostlist_edit').html(data);
                    } else {
                    $('#id_fabric_compostlist_edit').fadeOut();
                    $('#id_fabric_compostlist_edit').empty();
                    $('#id_fabric_compost_edit').val('');
                    $('#fabric_compost_edit').val('');
                    }
                }
            });
        }
    });
  });
</script>