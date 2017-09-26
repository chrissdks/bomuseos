
<table class="table table-hover">
	@if(isset($allreservations))
		<thead>
			
			<th>Fecha</th>
			<th>Dueño</th>
			<th>Mascota</th>
			<th>Tipo De Reserva</th>

		</thead>
		<tbody>
		@foreach($allreservations as $row)
		@if($rol==4)
			@if($id==$row->user_id)
			<tr>
				<td>{{\Carbon\Carbon::parse($row->date)->format('d/m/Y H:i')}}</td>
				<td>{{ $row->uname }} {{ $row->ulname }} </td>
				<td>{{ $row->pname }}</td>
				<td>@if($row->tipo_res==1)
						Peluqueria
					@endif
					@if($row->tipo_res==0)
						Consulta
					@endif
				</td>
				<td>
					<?php
                    $date = \Carbon\Carbon::parse($row->date)->format('Y/m/d');
					$dateToday = \Carbon\Carbon::today()->addDay(1)->format('Y/m/d');
                    if($date <= $dateToday) {
                        ?>

						<input type="submit" class="btn btn-warning btn-xs disabled" value="Modificar" >
					<?php
                    } else {
                        ?>
						<a href="reservations/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
						<?php
                    }
					?>

				<td>
                    <?php
                    $date = \Carbon\Carbon::parse($row->date)->format('Y/m/d');
                    $dateToday = \Carbon\Carbon::today()->addDay(1)->format('Y/m/d');

                    if($date <= $dateToday) {
                        ?>

							<input type="submit" class="btn btn-danger btn-xs disabled" value="Eliminar" >


				</td>
                <?php
                } else {
                ?>

				<form action="{{ route('reservations.destroy',$row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
                <?php
                }
                ?>
			</tr>
			@else
			@endif
		@else
			<tr>
				<td>{{\Carbon\Carbon::parse($row->date)->format('d/m/Y H:i')}}</td>
				<td>{{ $row->uname }} {{ $row->ulname }} </td>
				<td>{{ $row->pname }}</td>
				<td>@if($row->tipo_res==1)
						Peluqueria
					@endif
					@if($row->tipo_res==0)
						Consulta
					@endif
				</td>
				<td>
					<?php
                    $date = \Carbon\Carbon::parse($row->date)->format('Y/m/d');
					$dateToday = \Carbon\Carbon::today()->addDay(1)->format('Y/m/d');
                    if($date <= $dateToday) {
                        ?>

						<input type="submit" class="btn btn-warning btn-xs disabled" value="Modificar" >
					<?php
                    } else {
                        ?>
						<a href="reservations/{{ $row->id }}/edit" class="btn btn-warning btn-xs">Modificar</a></td>
						<?php
                    }
					?>

				<td>
                    <?php
                    $date = \Carbon\Carbon::parse($row->date)->format('Y/m/d');
                    $dateToday = \Carbon\Carbon::today()->addDay(1)->format('Y/m/d');

                    if($date <= $dateToday) {
                        ?>

							<input type="submit" class="btn btn-danger btn-xs disabled" value="Eliminar" >


				</td>
                <?php
                } else {
                ?>

				<form action="{{ route('reservations.destroy',$row->id) }}" method="POST" >
					<input type="hidden" name="_method" value="DELETE">
					{{ csrf_field() }}
					<input type="submit" class="btn btn-danger btn-xs" value="Eliminar" >
				</form>

				</td>
                <?php
                }
                ?>
			</tr>
		@endif
		@endforeach
		</tbody>
	@endif
</table>
{