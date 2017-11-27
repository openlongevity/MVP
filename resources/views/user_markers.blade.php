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
	jQuery(function($) {
	    $(document).ready( function () {
		$(document).on("click", "#btn-add-markers", function(e) {
		    // $("#user_markers_table:not(:last-child)").empty();
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
		})
	    });
	});

    </script>
@endsection

@section('content')

<!-- Modal for newsletter button. -->
<div id="add-markers-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Добавление маркера</h4>
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

<div class="container profile-content">
    <div class="row mymarkers-row">
	<div class="profile-full-name">
	    Мои маркеры
	    <a class="btn btn-xs btn-ol-edit" href="#" id="btn-add-markers">Добавить маркеры</a>
	</div>
	@if (!count($markers))
	    Вы пока не добавили ни одного анализа
	@endif
    </div>
</div>
@endsection


