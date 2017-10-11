<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>{{$marker->name}}</title>

</head>
<body>

<main>
	<div>
		<div>
			<h1>Marcador {{$marker->name}}</h1>
		</div>
	</div>
	<table>
		<thead>
		<tr>

			<th>NOMBRE</th>


		</tr>
		</thead>
		<tbody>
		<tr>
			<td>{{$marker->name}}</td>

			</tr>

		<tr>
			<td><img src="{{$marker->marker_path}}"></td>
		</tr>

		</tbody>

	</table>
</body>
</html>