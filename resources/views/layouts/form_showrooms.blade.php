

@if(session()->has('msj'))
<div class="alert alert-success">{{ session('msj') }}</div>
@endif
@if(session()->has('errormsj'))
<div class="alert alert-danger">{{ session('errormsj') }}</div>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ url('showrooms') }}">
{{ csrf_field() }}


    <div class="form-group">
        <label for="family" class="col-lg-2 control-label">Museo</label><span class="fa fa-list-alt"></span>
        <div class="col-lg-10">
            <select class="form-control" name="museum" id="museum" required>
                <option value="" disabled="true" selected="">Elija un museo</option>
                @foreach($museum as $row)
                    <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
                @if($errors->has('museum'))
                    <span style="color:red;">{{ $errors->first('museum') }}</span>
                @endif
            </select>
        </div>
    </div>



    <div class="form-group">
        <label for="address" class="col-lg-2 control-label">Nombre</label> <span class="fa fa-bank"></span>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="name" placeholder="Ingrese el nombre del museo" required>
            @if($errors->has('name'))
                <span style="color:red;">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-default">Guardar</button>
    </div>
  </div>
  <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<!---
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','#family',function(){
			var id=$(this).val();
			console.log(id);
			var div=$(this).parent();
			var op=" ";
			$.ajax({
				type:'get',
				url:'{!!URL::to('findBreed')!!}',
				data:{'id':id},
				success:function(data){
					op+='<option selected disabled>Choose a Breed</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
					}
					console.log(op);

					$('#breed').html("");
					$('#breed').append(op);
				},
				error:function(){

				}
			});
		});
	}); -->
</script>