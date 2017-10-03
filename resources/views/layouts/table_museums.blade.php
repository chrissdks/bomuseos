

<table class="table table-hover">
	@if(isset($museum))
		<thead>
			<th>Museo</th>
			<th>Dirección</th>
			<th>Teléfono</th>

		</thead>
		<tbody>
		@foreach($museum as $row)
		<tr>
				<td>{{ $row->name }}</td>
				<td>{{ $row->address }}</td>
				<td>{{ $row->phone }}</td>


				<td><a href="museums/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
				<td>
					<form action="{{ route('museums.destroy', $row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
			</tr>

			
		@endforeach
		</tbody>
		{{$museum->render()}}
	@endif
</table>