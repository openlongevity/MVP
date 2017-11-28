@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

    <script type="text/javascript">
	var olManager = new ol.manager();
            var markers = {
                @foreach ($markers as $aObj)
		    {{$aObj->id}}:
                    {
                        id: "{{$aObj->id}}",
                        marker_id: "{{$aObj->marker_id}}",
                        value: "{{$aObj->value}}",
                        ref_lab_value_min: "{{$aObj->ref_lab_value_min}}",
                        ref_lab_value_max: "{{$aObj->ref_lab_value_max}}",
                        lab: "{{$aObj->lab}}",
                        lab_units: "{{$aObj->lab_units}}",
                        date: "{{$aObj->date}}",
                    },
                @endforeach
            };

	jQuery(function($) {
	    $(document).ready( function () {
		$(document).on("click", "#btn-add-markers", function(e) {
		    $("#user_markers_table tbody").find("tr:not(:last)").remove();
		    $('#add-markers-modal').modal();
		});

		$('.marker_id').select2({
		    dropdownParent: $('#add-markers-modal')
		});

		$(document).on("change", "#marker_chooser", function(e) {
		    olManager.createRowWithMarker();
		});
		
		$(document).on("click", "#save_markers_btn", function(e) {
		    $('#submit_handle').click();
		    return false;
		});
		$('#add_markers_form').on('submit', function(e){
		    olManager.saveUserMarkers();
		    e.preventDefault();
		    return false;
		});
		
		$('#marker_id').select2({
		    dropdownParent: $('#edit-marker-modal')
		});
		$(document).on("click", ".edit_marker", function(e) {
		    var marker = markers[$(this).attr('data-marker-id')];

		    // Fill values.
		    $('#id').val(marker.id).change();
		    $('#marker_id').val(marker.marker_id).change();
		    $('#value').val(marker.value);
		    $('#ref_lab_value_min').val(marker.ref_lab_value_min);
		    $('#ref_lab_value_max').val(marker.ref_lab_value_max);
		    $('#lab').val(marker.lab);
		    $('#lab_units').val(marker.lab_units);
		    $('#date').val(marker.date);
		    
		    // show modal
		    $('#edit-marker-modal').modal();
		});
		
		
		$(document).on("click", "#edit_marker_btn", function(e) {
		    $('#submit_handle_edit_marker').click();
		    return false;
		});
		$('#edit_marker_form').on('submit', function(e){
		    olManager.saveUserMarker();
		    e.preventDefault();
		    return false;
		});
		$(document).on("click", "#delete-marker", function(e) {
		    // show confirm delete modal
		    $('#confirm-delete').modal();
		    return false;
		});
		$(document).on("click", "#delete-marker-forever", function(e) {
		    olManager.deleteMarker();
		    return false;
		});
	    });
	});

    </script>
@endsection

@section('content')

<!-- Modal for add markers button. -->
<div id="add-markers-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Добавление маркеров</h4>
	    Выберите необходимый вам анализ и заполните его значение
        </div>
	<div class="modal-body">
	    <form id="add_markers_form">
	    <table class="table" id="user_markers_table">
		<thead>
		    <tr>
			<th>
			    Название
			</th>
			<th>
			    Значение
			</th>
			<th>
			    Ед. изм.
			</th>
			<th>
			    Лаб. референс (мин)
			</th>
			<th>
			    Лаб. референс (макс)
			</th>
			<th>
			    Лаборатория
			</th>
			<th>
			    Дата
			</th>
			<th>
			</th>
		    </tr>
		</thead>
		<tbody>
		    <tr>
			<td>
			    <select name="marker_id" class="marker_id js-example-basic-single markers_select" id="marker_chooser">
				<option value="0">Выберите маркер</option>
				@foreach($allMarkers as $marker) 
				    <option value="{{$marker->id}}">{{$marker->name}}</option>
				@endforeach
			    </select>
			</td>
			<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
		    </tr>
		</tbody>
	    </table>
	    <div>
		<button class="btn btn-md btn-ol-login" value="Сохранить" id="save_markers_btn"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Загрузка...">Загрузить данные</button>
                <button type="button" class="btn btn-md btn-ol-cancel" data-dismiss="modal" aria-label="Close">Закрыть</button>
		<input id="submit_handle" type="submit" style="display: none">
		<input name="count_rows" type="hidden" id="count_rows"/>
	    </div>
	    </form>
        </div>
    </div>
</div>
</div>

<!-- Modal for edit markers button. -->
<div id="edit-marker-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Редактирование маркера</h4>
        </div>
	<div class="modal-body">
	    <form id="edit_marker_form">
	    <table class="table" id="add_marker_table">
		<thead>
		    <tr>
			<th>
			    Название
			</th>
			<th>
			    Значение
			</th>
			<th>
			    Ед. изм.
			</th>
			<th>
			    Лаб. референс (мин)
			</th>
			<th>
			    Лаб. референс (макс)
			</th>
			<th>
			    Лаборатория
			</th>
			<th>
			    Дата
			</th>
		    </tr>
		</thead>
		<tbody>
<tr id="marker_row">
    <td>
        <select name="marker_id" class="marker_id js-example-basic-single markers_select" id="marker_id">
    	<option value="0">Выберите маркер</option>
        @foreach($allMarkers as $marker) 
	   <option value="{{$marker->id}}">{{$marker->name}}</option>
        @endforeach
        </select>
    </td>
    <td>
        <input name="value" size="7" required="required" type="number" class="number-input" step="any" id="value"></input>
    </td>
    <td>
        <input name="lab_units" size="7" id="lab_units"></input>
    </td>
    <td>
        <input name="ref_lab_value_min" size="7" type="number" class="number-input" step="any" id="ref_lab_value_min"></input>
    </td>
    <td>
        <input name="ref_lab_value_max" size="7" type="number" class="number-input" step="any" id="ref_lab_value_max"></input>
    </td>
    <td>
        <input name="lab" size="15" id="lab"></input>
    </td>
    <td>
	<input name="date" size="8" class="date" required="required" readonly id="date"></input>
    </td>
</tr>
		</tbody>
	    </table>
	    <div>
		<button class="btn btn-md btn-ol-login" value="Сохранить" id="edit_marker_btn"  data-loading-text="<i class='fa fa-spinner fa-spin'></i> Загрузка...">Сохранить</button>
                <button type="button" class="btn btn-md btn-ol-cancel" data-dismiss="modal" aria-label="Close">Закрыть</button>
                <button type="button" class="btn btn-md btn-ol-delete" id="delete-marker">Удалить маркер</button>
		<input id="submit_handle_edit_marker" type="submit" style="display: none">
		<input name="id" type="hidden" id="id"/>
	    </div>
	    </form>
        </div>
    </div>
</div>
</div>


<!-- Modal for deleting marker. -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Вы действительно хотите удалить данный маркер?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-md btn-ol-cancel" data-dismiss="modal">Отмена</button>
                <a class="btn  btn-md btn-ol-delete" id="delete-marker-forever">Удалить</a>
            </div>
        </div>
    </div>
</div>

<div class="container profile-content">
    <div class="row mymarkers-row">
	<div class="my-markers-header">
	    Мои маркеры
	</div>
	@if (!count($markers))
	    Вы пока не добавили ни одного анализа
	@else
	    @include('user_markers_table', [])
	@endif
	<div>
	    &nbsp;
	</div>
	<div>
	    <a class="btn btn-md btn-ol-login" href="#" id="btn-add-markers">Добавить анализы</a>
	</div>
    </div>
</div>
@endsection


