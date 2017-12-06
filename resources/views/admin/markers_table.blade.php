<table class="table" id="markers">
    <thead>
	<tr class="table-header">
	    <th>Название</th>
	    <th>Синонимы</th>
	    <th>Ед. измерения</th>
	    <th class="no-sort"></th>
	</tr>
    </thead>
    <tbody>
	@foreach($aMarkers as $marker)
	<tr>
	    <td>{{$marker->name}}</td>
	    <td>{{$marker->names}}</td>
	    <td>{{$marker->units}}</td>
	    <td>
		<a href="/admin/marker/edit/{{$marker->id}}" class="edit_marker" data-marker-id="{{$marker->id}}"><span class="glyphicon glyphicon-edit"></span></a>
		<a href="#" class="remove_marker" data-marker-id="{{$marker->id}}"><span class="glyphicon glyphicon-remove"></span></a>
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>



