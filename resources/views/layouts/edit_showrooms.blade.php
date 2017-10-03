@if(isset($edit))
<form class="form-horizontal" role="form" method="POST" action="{{ route('showrooms.update', $editshowroom->last()->id) }}">
<input type="hidden" name="_method" value="PUT">
{{ csrf_field() }}
	<div class="form-group">
		<label for="family" class="col-lg-2 control-label">Museo</label><span class="fa fa-list-alt"></span>
		<div class="col-lg-10">
			<select class="form-control" name="museum" id="museum" required>
				@foreach($museums as $row)
					@if($row->id==$editshowroom->last()->museum_id)
						<option selected="{{$row->id}}">{{$row->name}}</option>
					@else
					<option value="{{$row->id}}">{{$row->name}}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>



	<div class="form-group">
		<label for="address" class="col-lg-2 control-label">Nombre</label> <span class="fa fa-bank"></span>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="name" placeholder="Ingrese el nombre del museo"  value="{{$editshowroom->last()->name}}" required>
			@if($errors->has('name'))
				<span style="color:red;">{{ $errors->first('name') }}</span>
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


@endif