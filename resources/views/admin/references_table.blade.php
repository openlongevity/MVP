<form id="ref_marker_form">
    <table class="table" id="ref_marker">
	<thead>
	    <tr class="table-header">
		<th>Пол</th>
		<th>Возраст</th>
		<th>Референс минимальный</th>
		<th>Референс максимальный</th>
		<th></th>
	    </tr>
	</thead>
	<tbody>
	@foreach($aMarkerRefs as $key => $oMRef)
	    @include('admin/reference_row', ['index' => $key, 'oMRef' => $oMRef])
	@endforeach
	</tbody>
    </table>

    <a href="#" class="add_ref_marker" title="Добавить новый референс"><span class="glyphicon glyphicon-plus"></span></a>

    <input type="hidden" name="{{$panel_id}}">
</form>
