<tr id="row_{{$oMarker->id}}">
    <td id="marker_name_{{$oMarker->id}}">{{$oMarker->name}}</td>
    <td>
	<a href="#" class="edit_marker_reference" data-marker-id="{{$oMarker->id}}" data-marker-units="{{$oMarker->units}}"><span class="glyphicon glyphicon-edit"></span></a><br />
	@foreach($oMarker->refs($oPanel->id) as $oRef)
	    {{$oRef->toString($oMarker->units)}} <br />
	@endforeach
    </td>
    <td>
        <a href="#" class="remove_marker" data-marker-id="{{$oMarker->id}}" title="Удалить маркер из панели"><span class="glyphicon glyphicon-remove"></span></a>
    </td>
</tr>

