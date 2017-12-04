<table class="table" id="markers">
    <thead>
	<tr class="table-header">
	    <th>Название</th>
	    <th>Синонимы</th>
	    <th>Ед. измерения</th>
	</tr>
    </thead>
    <tbody>
	@foreach($aMarkers as $marker)
	<tr>
	    <td>{{$marker->name}}</td>
	    <td>{{$marker->names}}</td>
	    <td>{{$marker->units}}</td>
	</tr>
	@endforeach
    </tbody>
</table>



