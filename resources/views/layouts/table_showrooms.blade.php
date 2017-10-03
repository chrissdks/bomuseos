

<table class="table table-hover">
	@if(isset($showroom))
		<thead>
			<th>Sala</th>
			<th>Museo</th>

		</thead>
		<tbody>
		@foreach($showroom as $row)
		<tr>
				<td>{{ $row->showroom }}</td>
				<td>{{ $row->museum }}</td>



				<td><a href="showrooms/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
				<td>
					<form action="{{ route('showrooms.destroy', $row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
			</tr>

			
		@endforeach
		</tbody>
		{{$showroom->render()}}
	@endif
</table>