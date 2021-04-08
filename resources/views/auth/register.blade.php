@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="perusahaan"
                                class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>

                            <div class="col-md-6">
                                <input type="hidden" id="kd_perusahaan" type="text"
                                    class="form-control @error('kd_perusahaan') is-invalid @enderror"
                                    name="kd_perusahaan" value="{{ old('kd_perusahaan') }}" required autocomplete="off">
                                <input id="perusahaan" type="text"
                                    class="form-control @error('kd_perusahaan') is-invalid @enderror" name="perusahaan"
                                    value="{{ old('perusahaan') }}" required autocomplete="off">
                                <span>
                                    <div id="kd_perusahaanList"></div>
                                </span>

                                @error('kd_perusahaan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kd_divisi"
                                class="col-md-4 col-form-label text-md-right">{{ __('Division') }}</label>

                            <div class="col-md-6">
                                <input type="hidden" id="kd_divisi" type="text"
                                    class="form-control @error('kd_divisi') is-invalid @enderror" name="kd_divisi"
                                    value="{{ old('kd_divisi') }}" required autocomplete="off">
                                <input id="divisi" type="text"
                                    class="form-control @error('kd_divisi') is-invalid @enderror" name="divisi"
                                    value="{{ old('divisi') }}" required autocomplete="off">
                                <span>
                                    <div id="kd_divisiList"></div>
                                </span>

                                @error('kd_divisi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
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
        $('#divisi').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.divisi') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#kd_divisiList').fadeIn();
                            $('#kd_divisiList').html(data);
                        } else {
                            $('#kd_divisiList').fadeOut();
                            $('#kd_divisiList').empty();
                            $('#kd_divisi').val('');
                            $('#divisi').val('');
                        }
                    }
                });
            }
        });
        $('#perusahaan').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.perusahaan') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#kd_perusahaanList').fadeIn();
                            $('#kd_perusahaanList').html(data);
                        } else {
                            $('#kd_perusahaanList').fadeOut();
                            $('#kd_perusahaanList').empty();
                            $('#kd_perusahaan').val('');
                            $('#perusahaan').val('');
                        }
                    }
                });
            }
        });
    });

    function pilihDivisi($ls){
        var ls = $ls;
        var ls = $ls;
        $('#kd_divisi').val($('#kd_dvsi'+ls).text());
        $('#divisi').val($('#dvsi'+ls).text());
        $('#kd_divisiList').fadeOut();
    }

    function pilihPer($ls){
        var ls = $ls;
        var ls = $ls;
        $('#kd_perusahaan').val($('#kd_per'+ls).text());
        $('#perusahaan').val($('#per'+ls).text());
        $('#kd_perusahaanList').fadeOut();
    }
</script>
