
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class=""> 
 
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/quotation') }}">Quotation</a></li>
      <li class="breadcrumb-item active">Import</li>
  </ol>
 
        @if ($sukses = Session::get('sukses'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $sukses }}</strong>
        </div>
        @endif
        @if ($error = Session::get('error'))
        <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $error }}</strong>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                Import Quptation
            </div>
            <div class="card-body">
              <form method="post" action="/quotation/getValue"  enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="container">
              <div class="form-row">
                  <div class="row">
                    <input type="file" id="file" name="file" class="form-control" onchange="checkfile(this)" accept=".xlsm" required>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="row">
                    <input type="submit" class="btn btn-success" value="Import">
                  </div>
              </div>
              </div>
            </form>
            </div>
        </div>
    </div>


@endsection
<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsm");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      sender.value='';
      return false;
    }
    else return true;
}
</script>
