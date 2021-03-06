
<table class="table table-hover">
	@if(isset($artifact))
		<thead>
		<th>Artefacto</th>
		<th>Sala</th>
		<th>Museo</th>

		</thead>
		<tbody>
		@foreach($artifact as $row)
			<tr>
				<td>{{ $row->artifact }}</td>
				<td>{{ $row->showroom }}</td>
				<td>{{ $row->museum }}</td>



				<td><a href="artifacts/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
				<td>
					<form action="{{ route('artifacts.destroy', $row->id) }}" method="POST" >
						<input type="hidden" name="_method" value="DELETE">
						{{ csrf_field() }}
						<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
					</form>

				</td>

				<td>
					<a href="{{action('ArtifactController@print_marker', $row->id)}}"class="btn btn-info btn-xs" target="_blank">PDF</a>

				</td>


			</tr>


		@endforeach
		</tbody>
		{{$artifact->render()}}
	@endif
</table>