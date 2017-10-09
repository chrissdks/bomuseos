@if(session()->has('msj'))
<div class="alert alert-success">{{ session('msj') }}</div>
@endif
@if(session()->has('errormsj'))
<div class="alert alert-danger">{{ session('errormsj') }}</div>
@endif

<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ url('reservations') }}">
{{ csrf_field() }}
    


  <div class="form-group {{ $errors->has('pet') ? ' has-error' : '' }}">
    <label for="pet" class="col-lg-2 control-label"> Nombre</label>
    <div class="col-lg-10">
      <input class="form-control" name="name" id="name" required>
        
      </input>
        @if($errors->has('pet'))
            <div class="alert alert-danger">
            {{$errors->first('pet')}}
            </div>
        @endif
    </div>
  </div>



 <!-- <div class="form-group {{ $errors->has('pet') ? ' has-error' : '' }}">
    <label for="pet" class="col-lg-2 control-label"> marcador</label>
    <div class="col-lg-10">
      <input type="file" name="marcador">
      
        
      </input>
        @if($errors->has('pet'))
            <div class="alert alert-danger">
            {{$errors->first('pet')}}
            </div>
        @endif
    </div>
  </div>
-->
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-default">Save</button>
    </div>
  </div>
</form>



<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->margin(0)->size(480)->backgroundColor(255,255,255)->generate('TEST NUEVO')) !!} ">
 
