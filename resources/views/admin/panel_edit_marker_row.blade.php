<tr id="row_{{$oMarker->id}}">
    <td>{{$oMarker->name}}</td>
    <td>
        <a href="#" class="edit_marker_reference" data-marker-id="{{$oMarker->id}}"><span class="glyphicon glyphicon-edit"></span></a><br />
    </td>
    <td>
        <a href="#" class="remove_marker" data-marker-id="{{$oMarker->id}}" title="Удалить маркер из панели"><span class="glyphicon glyphicon-remove"></span></a>
    </td>
</tr>

