<table class="table" id="user_markers_table_main">
    <thead>
	<tr class="table-header">
	    <th>Название</th>
	    <th>Результат</th>
	    <th>Норма лаборатории</th>
	    <th>Норма OL</th>
	    <th>Лаборатория</th>
	    <th>Дата сдачи анализа</th>
	    <th></th>
	</tr>
    </thead>
    <tbody>
	@foreach($markers as $marker)
	<tr>
	    <td><a href="/markers/marker/{{$marker->id}}">{{$marker->name}}</a></td>
	    <td>{{$marker->value}} {{$marker->lab_units}}</td>
	    <td class="@if ($marker->fail) marker-fail @else marker-success @endif">{{$marker->ref_lab_value_min}} - {{$marker->ref_lab_value_max}} {{$marker->lab_units}}</td>
	    <td
		@php
		switch ($marker->checkRef(1)) {
		    case 0:
			echo 'class="marker-success"';
			break;
		    case 1:
			echo 'class="marker-fail"';
			break;
		}
		@endphp
	    >

		@foreach($marker->refs(1) as $oRef)
		    {{$oRef->toString($marker->units)}} <br />
		@endforeach
	    </td>
	    <td>{{$marker->lab}}</td>
	    <td>{{$marker->date}}</td>
	    <td>
		<a href="#" class="edit_marker" data-marker-id="{{$marker->id}}"><span class="glyphicon glyphicon-edit"></span></a>
	    </td>
	</tr>
	@endforeach
    </tbody>
</table>
