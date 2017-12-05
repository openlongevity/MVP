<table class="table">
    <thead>
	<tr class="table-header">
	    <th>Название</th>
	    <th>Количество маркеров</th>
	    <th></th>
	</tr>
    </thead>
    <tbody>
	@foreach($panels as $panel)
	<tr>
	    <td><a href="/panel/{{$panel->id}}">{{$panel->name}}</a></td>
	    <td>{{count($panel->getMarkers())}}</td>
	    <td>
		<a href="/admin/panel/edit/{{$panel->id}}" class="edit_panel" data-marker-id="{{$panel->id}}"><span class="glyphicon glyphicon-edit"></span></a>
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>

