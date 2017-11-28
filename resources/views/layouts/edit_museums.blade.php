@if(isset($edit))
<form class="form-horizontal" role="form" method="POST" action="{{ route('museums.update', $editmuseum->last()->id) }}">
<input type="hidden" name="_method" value="PUT">
{{ csrf_field() }}
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">Nombre</label> <span class="fa fa-bank"></span>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="name" placeholder="Ingrese el nombre del museo" value="{{$editmuseum->last()->name}}" required>
			@if($errors->has('name'))
				<span style="color:red;">{{ $errors->first('name') }}</span>
			@endif
		</div>
	</div>





	<div class="form-group">
		<label for="address" class="col-lg-2 control-label">Dirección</label> <span class="fa fa-home"></span>

		<div class="col-lg-10">
			<input type="text" class="form-control" name="address" placeholder="Ingrese la dirección del museo"  value="{{$editmuseum->last()->address}}" required>
			@if($errors->has('address'))
				<span style="color:red;">{{ $errors->first('address') }}</span>
			@endif
		</div>
	</div>

	<div class="form-group">
		<label for="phone" class="col-lg-2 control-label">Teléfono</label> <span class="fa fa-phone"></span>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="phone" placeholder="Ingrese el teléfono"  value="{{$editmuseum->last()->phone}}" required>
			@if($errors->has('phone'))
				<span style="color:red;">{{ $errors->first('phone') }}</span>
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
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
			</td>
			<td>
				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10" style="margin-left: 100px;">
						<a  href="{{route('museums.index')}}" class="btn btn-danger">Cancelar</a>
					</div>
				</div>
			</td>
		</tr>
	</table>
</form>


@endif