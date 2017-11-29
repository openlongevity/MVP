<table class="table">
    <thead>
	<tr class="table-header">
	    <th>Название</th>
	    <th>Показание</th>
	    <th>Референс</th>
	    <th>Значение OL 1.1</th>
	    <th>Лаборатория</th>
	    <th>Дата</th>
	    <th></th>
	</tr>
    </thead>
    <tbody>
	@foreach($markers as $marker)
	<tr>
	    <td>{{$marker->name}}</td>
	    <td>{{$marker->value}} {{$marker->lab_units}}</td>
	    <td class="@if ($marker->fail) marker-fail @else marker-success @endif">{{$marker->ref_lab_value_min}} - {{$marker->ref_lab_value_max}} {{$marker->lab_units}}</td>
	    <td></td>
	    <td>{{$marker->lab}}</td>
	    <td>{{$marker->date}}</td>
	    <td>
		<a href="#" class="edit_marker" data-marker-id="{{$marker->id}}"><span class="glyphicon glyphicon-edit"></span></a>
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>
