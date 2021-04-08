
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class=""> 
 
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/material') }}">Material</a></li>
      <li class="breadcrumb-item active">Edit Data Material</li>
  </ol>

        <div class="card">
            <div class="card-header">
                Input Data Material
            </div>
            <div class="card-body">
              <form method="post" action="/material/update"  enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="container">
                <div class="form-row">
                  <div class="col-md-5">
                    <div class="row">
                      <label>Material Code<span style="color: red"> *</span></label>
                      <input type="text" name="code" value="{{ $material->code }}" class="form-control @error('code') is-invalid @enderror" autocomplete="off" readonly>
                      @error('code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Tipe Material<span style="color: red"> *</span></label>
                      <select name="tipe" class="form-control" required class="form-control @error('tipe') is-invalid @enderror">
                        <option value="{{ $material->tipe }}" selected>{{ $material->tipe }}</option>
                        <option value="Fabric">Fabric</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Auxiliaries">Auxiliaries</option>
                      </select>
                      @error('tipe')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Deskripsi Material<span style="color: red"> *</span></label>
                      <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" autocomplete="off" rows="3">{{ $material->deskripsi }}</textarea>
                      @error('deskripsi')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-5">
                    <div class="row">
                      <label>Remarks</label>
                      <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" autocomplete="off" rows="3">{{ $material->remarks }}</textarea>
                      @error('remarks')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-auto">
                    <div class="row">
                      <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}" required>
                      <label><p align="right">Field dengan<span style="color: red"> *</span> Wajib di isi<p></label>
                    </div>
                    <br>
                    <div class="row">
                        <p align="right"><input type="submit" class="btn btn-success" value="Simpan Material"></p>
                    </div>
                  </div>

                </div>
              </div>
              
            </form>
            </div>
        </div>
    </div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#satuan').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.satuan') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#satuanList').fadeIn();  
                            $('#satuanList').html(data);
                        } else {
                            $('#satuanList').fadeOut();
                            $('#satuanList').empty();
                            $('#satuan').val('');
                            $('#satuan').val('');
                        }
                    }
                });
            }
        });
    });

    function pilihSatuan($ls){
        var ls = $ls;
        var ls = $ls; 
        $('#satuan').val($('#stn'+ls).text());  
        $('#satuanList').fadeOut();
    }

</script>