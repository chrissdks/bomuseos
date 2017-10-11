@if(session()->has('msj'))
<div class="alert alert-success">{{ session('msj') }}</div>
@endif
@if(session()->has('errormsj'))
<div class="alert alert-danger">{{ session('errormsj') }}</div>
@endif

<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ url('artifacts') }}">
{{ csrf_field() }}

    <div class="form-group">
        <div class="col-sm-6">
            <label for="museum" class="control-label">Museo</label><span class="fa fa-bank"></span>
            <select class="form-control" name="museum" id="museum" required>
                <option value="" disabled="true" selected="">Elija un museo</option>
                @foreach($museum as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
            </select>
            @if($errors->has('museum'))
                <span style="color:red;">{{ $errors->first('museum') }}</span>
            @endif
        </div>

        <div class="col-sm-6">
            <label for="showroom" class="control-label">Sala</label><span class="fa fa-list-alt"></span>
            <select class="form-control" name="showroom" id="showroom" required>
                <option value="" disabled="true" selected="">Elija una Sala</option>
            </select>
        @if($errors->has('showroom'))
            <span style="color:red;">{{ $errors->first('showroom') }}</span>
        @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-6">
                <label for="name" class="control-label"> Nombre</label> <span class="glyphicon glyphicon-knight"></span>
                <input class="form-control" name="name" id="name" value="{{ old('name') }}" required> </input>
                @if($errors->has('name'))
                    <span style="color:red;">{{ $errors->first('name') }}</span>
                @endif
        </div>

        <div class="col-sm-6">
            <label for="type" class="control-label">Tipo</label><span class="glyphicon glyphicon-tag"></span>
            <select class="form-control" name="type" id="type" value="{{ old('type') }}" required>
                <option value="" disabled="true" selected="">Elija un tipo</option>
                <option value="1" @if(old('type') == "1") {{ 'selected' }} @endif>Pieza</option>
                <option value="2" @if(old('type') == "2") {{ 'selected' }} @endif>Coleccion</option>
            </select>
            @if($errors->has('type'))
                <span style="color:red;">{{ $errors->first('type') }}</span>
            @endif
        </div>
    </div>


    <div class="col-lg-10">
        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="name" class="control-label"> Descripcion</label> <span class="glyphicon glyphicon-edit"></span>
      <textarea class="form-control" name="description" style="margin: 0px -115.672px 0px 0px; width: 713px; height: 111px;" id="description" required> {{ old('description') }}</textarea>
            @if($errors->has('description'))
                <span style="color:red;">{{ $errors->first('description') }}</span>
            @endif

    </div>
  </div>



    <div class="col-lg-10">
       <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
        <label for="image" class="control-label"> Imagen</label> <span class="glyphicon glyphicon-picture"></span>
      <input type="file" name="image"> </input>
       </div>
    </div>

    <div class="col-lg-10">
        <div class=" form-group {{ $errors->has('video') ? ' has-error' : '' }}">
            <label for="video" class="control-label"> Video</label><span class="glyphicon glyphicon-facetime-video"></span>
            <input type="file" name="video"> </input>

        </div>
    </div>

  <div class="form-group">
    <div class="col-lg-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
</form>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#museum',function(){
            var id=$(this).val();
            console.log(id);
            var div=$(this).parent();
            var op=" ";
            $.ajax({
                type:'get',
                url:'{!!URL::to('findShowroom')!!}',
                data:{'id':id},
                success:function(data){
                    op+='<option value="" disabled="true" selected="" >Elija una sala</option>';
                    for(var i=0;i<data.length;i++){

                        op+='<option value="'+data[i].id+'">'+data[i].name+' </option>'
                    }
                    console.log(op);

                    $('#showroom').html("");
                    $('#showroom').append(op);
                },
                error:function(){

                }
            });
        });
    });
</script>