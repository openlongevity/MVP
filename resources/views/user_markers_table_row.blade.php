<tr id="marker_row_{{$index}}">
    <td>
        <select name="marker_id_{{$index}}" class="marker_id js-example-basic-single markers_select" id="marker_id_{{$index}}">
    	<option value="0">Выберите маркер</option>
        @foreach($allMarkers as $marker) 
    	<option value="{{$marker->id}}" @if ($oMarker->id == $marker->id) selected @endif>{{$marker->name}}</option>
        @endforeach
        </select>
    </td>
    <td>
        <input name="value_{{$index}}" size="7" required="required" type="number" class="number-input" step="any"></input>
    </td>
    <td>
        <input name="lab_units_{{$index}}" size="7" value="{{$oMarker->units}}"></input>
    </td>
    <td>
        <input name="ref_lab_value_min_{{$index}}" size="7" type="number" class="number-input" step="any"></input>
    </td>
    <td>
        <input name="ref_lab_value_max_{{$index}}" size="7" type="number" class="number-input" step="any"></input>
    </td>
    <td>
        <input name="lab_{{$index}}" size="15" ></input>
    </td>
    <td>
	<input name="date_{{$index}}" size="8" class="date" required="required" readonly></input>
    </td>
    <td>
	<a href="#" id="remove_{{$index}}"><span class="glyphicon glyphicon-remove"></span></a>
    </td>
</tr>

