

@if(session()->has('msj'))
<div class="alert alert-success">{{ session('msj') }}</div>
@endif
@if(session()->has('errormsj'))
<div class="alert alert-danger">No se guardaron los datos</div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="form-horizontal" role="form" method="POST" action="{{ url('museums') }}">
{{ csrf_field() }}
    <div class="form-group">
        <label for="address" class="col-lg-2 control-label">Nombre</label> <span class="fa fa-bank"></span>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="name" placeholder="Ingrese el nombre del museo" required>
            @if($errors->has('name'))
                <span style="color:red;">{{ $errors->all('name') }}</span>
            @endif
        </div>
    </div>





	  <div class="form-group">
	  <label for="address" class="col-lg-2 control-label">Dirección</label> <span class="fa fa-home"></span>

	  <div class="col-lg-10">
          <input type="text" class="form-control" name="address" placeholder="Ingrese la dirección del museo" required>
		  @if($errors->has('address'))
			  <span style="color:red;">{{ $errors->all('address') }}</span>
		  @endif
	  </div>
      </div>

          <div class="form-group">
              <label for="phone" class="col-lg-2 control-label">Teléfono</label> <span class="fa fa-phone"></span>
               <div class="col-lg-10">
                  <input type="text" class="form-control" name="phone" placeholder="Ingrese el teléfono" required>
                  @if($errors->has('phone'))
                      <span style="color:red;">{{ $errors->all('phone') }}</span>
                  @endif
              </div>





  </div>


  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-default">Grabar</button>
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