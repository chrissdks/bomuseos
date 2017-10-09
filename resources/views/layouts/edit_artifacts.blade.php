@if(isset($edit))
	<form class="form-horizontal" role="form" method="POST" action="{{ route('reservations.update', $allreservation->last()->id) }}">
		<input type="hidden" name="_method" value="PUT">
		{{ csrf_field() }}
		<div class="form-group {{ $errors->has('user_id') ? ' has-error' : '' }}">
			<label for="user-id" class="col-lg-2 control-label">Dueño</label>
			<div class="col-lg-10">
				<select class="form-control" name="user_id" id="user_id" >
					<option value="{{$allreservation->last()->uid}}">{{$allreservation->last()->uname}} {{$allreservation->last()->ulname}}</option>
						@foreach($users as $row)
                            @if($row->id==$allreservation->last()->uid)
                            @else
						        <option value="{{$row->user_id}}">{{$row->name}} {{$row->last_name}}</option>
                            @endif
					@endforeach
				</select>
				@if($errors->has('user_id'))
					<div class="alert alert-danger">
						{{$errors->first('user_id')}}
					</div>
				@endif
			</div>
		</div>



		<div class="form-group {{ $errors->has('pet') ? ' has-error' : '' }}">
			<label for="pet" class="col-lg-2 control-label"> Mascota</label>
			<div class="col-lg-10">
                <select class="form-control" name="pet" id="pet">
					<option value="{{$allreservation->last()->pid}}">{{$allreservation->last()->pname}}</option>
                    @foreach($lpets as $row)
                        @if($row->lpetid==$allreservation->last()->pid)
                        @else
                            <option value="{{$row->lpetid}}">{{$row->lpetname}}</option>
                        @endif
                    @endforeach
                </select>
				@if($errors->has('pet'))
					<div class="alert alert-danger">
						{{$errors->first('pet')}}
					</div>
				@endif
			</div>
		</div>

		<div class="form-group {{ $errors->has('tipo_res') ? ' has-error' : '' }}">
			<label for="tipo_res" class="col-lg-2 control-label">Tipo de Reserva</label>
			<div class="col-lg-10">
				<select class="form-control" name="tipo_res" id="tipo_res">
					@if($allreservation->last()->tipo_res==1)
						<option value="1">Peluqueria</option>
					@endif
					@if($allreservation->last()->tipo_res==0)
						<option value="0">Consulta</option>
					@endif
					@if($allreservation->last()->tipo_res==2)
						<option value="2">Quirofano</option>
					@endif
					<option value="1">Peluqueria</option>
					<option value="0">Consulta</option>
					<option value="2">Quirofano</option>
				</select>
				@if($errors->has('tipo_res'))
					<div class="alert alert-danger">
						{{$errors->first('tipo_res')}}
					</div>
				@endif
			</div>
		</div>

		<div class="form-group {{ $errors->has('sala') ? ' has-error' : '' }}">
			<label for="date" class="col-lg-2 control-label">Sala</label>
			<div class="col-lg-10">
				<select class="form-control" name="sala_id" id="sala_id"  required>
					<option selected="" value="{{$sala_id}}">{{$sala_name}}</option>
				</select>
				@if($errors->has('sala'))
					<div class="alert alert-danger">
						{{$errors->first('sala')}}
					</div>
				@endif
			</div>
		</div>

		<div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
			<label for="date" class="col-lg-2 control-label">Fecha</label>
			<div class="col-lg-10">
              <input type="datetime-local" class="form-control" id ="date" name="date" step="{{$step}}" value="{{str_replace(" ", "T",$allreservation->last()->date)}}" required>
				@if($errors->has('date'))
					<div class="alert alert-danger">
						{{$errors->first('date')}}
					</div>
				@endif
			</div>
		</div>


<table>
	<tr>
	<td>
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10" style="margin-left: 45px;">
				<button type="submit" class="btn btn-success">Update</button>
			</div>
		</div>
	</td>
<td>
		<div class="form-group">
			<div class="col-lg-offset-2 col-lg-10" style="margin-left: 100px;">
				<a  href="{{route('reservations.index')}}" class="btn btn-danger">Cancelar</a>
			</div>
		</div>
</td>
	</tr>
</table>
	</form>






	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

	<script type="text/javascript">
        $(document).ready(function(){
            $(document).on('change','#user_id',function(){
                var id=$(this).val();
                console.log(id);
                var div=$(this).parent();
                var op=" ";
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findPet')!!}',
                    data:{'id':id},
                    success:function(data){
                        op+='<option selected disabled>Elija Mascota</option>';
                        for(var i=0;i<data.length;i++){
                            op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                        }
                        console.log(op);
                        $('#pet').html("");
                        $('#pet').append(op);
                    },
                    error:function(){
                    }
                });
            });
            $('#sala_id').on('change',function(){

                var id=$(this).val();
                console.log(id);
                var div=$(this).parent();
                var op=" ";
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findFranja')!!}',
                    data:{'id':id},
                    success:function(data){
                        alert(data);
                        var print = $('#date').attr('step');
                        $('#date').attr('step',''+data);
                        console.log('foo'+print);
                    },
                    error:function(){
                    }
                });
            });

            $('#tipo_res').on('change',function () {
                var id=$(this).val();
                console.log(id);
                var div=$(this).parent();
                var op=" ";
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findSala')!!}',
                    data:{'id':id},
                    success:function(data){
                        console.log("lllllllega");
                        op+='<option selected="" value="{{$sala_id}}">{{$sala_name}}</option>';
                        for(var i=0;i<data.length;i++){
                            op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                        }
                        console.log(op);
                        $('#sala_id').html("");
                        $('#sala_id').append(op);
                    },
                    error:function(){
                    }
                });
            });
            $('#date').on('change',function () {
                var id=$(this).val();

                console.log(id);
                var div=$(this).parent();
                var op=" ";
                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findCheck')!!}',
                    data:{'id':id},
                    success:function(data){
                        if(data==1){
                            alert();
                        }
                        console.log(data);
                    },
                    error:function(){
                    }
                });
            });
        });
	</script>
@endif