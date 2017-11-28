<table class="table">
    <thead>
	<tr>
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
	    <td>{{$marker->ref_lab_value_min}} - {{$marker->ref_lab_value_max}} {{$marker->lab_units}}</td>
	    <td></td>
	    <td>{{$marker->lab}}</td>
	    <td>{{$marker->date}}</td>
	    <td>
		<a href="#" class="edit_marker"><span class="glyphicon glyphicon-edit"></span></a>
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>
