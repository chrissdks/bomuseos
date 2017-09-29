

<table class="table table-hover">
	@if(isset($my_pets))
		<thead>
			<th>Name</th>
			<th>Weight</th>
			<th>Height</th>
			<th>Age</th>
			<th>Gender</th>
			<th>Breed</th>
			<th>Owner</th>
		</thead>
		<tbody>
		@foreach($my_pets as $row)
		@if($rol==4)
			@if($id==$row->user_id)
				<tr>
				<td>{{ $row->pet }}</td>
				<td>{{ $row->weight }}</td>
				<td>{{ $row->height }}</td>
				<td>{{ $row->age }}</td>
				<td>@if($row->gender==1)
						Male
					@endif
					@if($row->gender==0)
						Female
					@endif</td>
				<td>{{ $row->breed }}</td>
				<td>{{ $row->user }}</td>
				<td><a href="pets/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
				<td>
					<form action="{{ route('pets.destroy', $row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
			</tr>
			@else
			@endif
		@else
		<tr>
				<td>{{ $row->pet }}</td>
				<td>{{ $row->weight }}</td>
				<td>{{ $row->height }}</td>
				<td>{{ $row->age }}</td>
				<td>@if($row->gender==1)
						Male
					@endif
					@if($row->gender==0)
						Female
					@endif</td>
				<td>{{ $row->breed }}</td>
				<td>{{ $row->user }}</td>
				<td><a href="pets/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
				<td>
					<form action="{{ route('pets.destroy', $row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
			</tr>
		@endif
			
		@endforeach
		</tbody>
		{{$my_pets->render()}}
	@endif
</table>