@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

    <link rel='stylesheet' type='text/css' href='{{asset("bootstrap-fileinput/css/fileinput.min.css")}}' />
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/fileinput.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/plugins/sortable.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/plugins/purify.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/themes/fa/theme.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/locales/ru.js")}}'></script>
    <script src="{{ asset('js/notify.js') }}"></script>

    <script type="text/javascript">
	var olManager = new ol.manager();
	jQuery(function($) {
	    $(document).ready( function () {
		$(document).on("click", "#add_panel_series", function(e) {
		    $('#add-markers-modal').modal();
		});

		$(document).on("click", "#save_panel_markers_btn", function(e) {
		    olManager.saveUserPanelMarkers({{$oPanel->id}});
		    e.preventDefault();
		    return false;
		});
		$(document).on("click", "#add_pdf_series", function(e) {
			$("#add-file-modal").modal();
                        $("#input-data-file").fileinput({
                            overwriteInitial: false,
                            initialCaption: "Файл анализов из лаборатории",
			    allowedFileExtensions: ['pdf'],
			    language: 'ru',
                            uploadUrl: '/panel/markers/add/file',
			    ajaxSettings: { headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }},
			    uploadExtraData: function () {
				return {panel_id: {{$oPanel->id}}}
			    },
																      

                        });
			$('#input-data-file').on('fileuploaded', function(event, data, previewId, index) {
			    $("#add-file-modal").modal('toggle');
			    $.notify("Данные отправлены успешно!", "success");
			});

		    e.preventDefault();
		    return false;
		});


		$('#add-file-modal').on('hidden.bs.modal', function (e) {
		    $('#input-interpretation-file').fileinput('clear');
		    $("#input-interpretation-file").fileinput('refresh');
		    $('#input-interpretation-file').fileinput('clearStack');
		    $('#input-interpretation-file').fileinput('destroy');
		});
		
                    
		$(document).on("click", ".add_marker_file", function(e) {
			var marker_id = $(this).attr('data-marker-id');
			var series_id = $(this).attr('data-series-id');
			var marker_name = $(this).attr('data-marker-name');
			var user_marker_id = $(this).attr('data-user-marker-id');
			$("#marker_name").html(marker_name);
			$("#add-marker-file-modal").modal();
                        $("#input-data-marker-file").fileinput({
                            overwriteInitial: false,
                            initialCaption: "Файл для маркера " + marker_name,
			    allowedFileExtensions: ['pdf', 'png', 'jpg'],
			    language: 'ru',
                            uploadUrl: '/panel/marker/add/file',
			    ajaxSettings: { headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }},
			    uploadExtraData: function () {
				    return  {panel_id: {{$oPanel->id}}, 
					     marker_id: marker_id,
					     user_marker_id: user_marker_id,
					     series_id: series_id,
					    }
			    },
																      

                        });
			$('#input-data-marker-file').on('fileuploaded', function(event, data, previewId, index) {
			    $("#add-marker-file-modal").modal('toggle');
			    $.notify("Данные отправлены успешно!", "success");
			    setTimeout(function() {
				location.reload();
			    }, 500);
			});

		    e.preventDefault();
		    return false;
		});


		$('#add-file-modal').on('hidden.bs.modal', function (e) {
		    $('#input-interpretation-file').fileinput('clear');
		    $("#input-interpretation-file").fileinput('refresh');
		    $('#input-interpretation-file').fileinput('clearStack');
		    $('#input-interpretation-file').fileinput('destroy');
		});

	    });
	});

    </script>
@endsection

@section('content')

<!-- Modal for add markers button. -->
<div id="add-markers-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Ручное заполнение маркеров</h4>
	    Заполняйте только те анализы, данные для которых  у вас есть. 
	    После загрузки данных пройдет некоторое время прежде чем вы увидите
	    результат в своей таблице маркеров.
	</div>
	<div class="modal-body">
	    <form id="add_markers_form">
	    <table class="table" id="user_markers_table">
		<tbody>
		    @foreach($oPanel->getMarkers() as $marker)
		    <tr>
			<td>
			    {{$marker->name}}
			</td>
			<td>
			    <input type="text" size="5" name="marker_{{$marker->id}}" id="marker_{{$marker->id}}">
			</td>
			<td>
			    <span title="{{$marker->units_full}}">{{$marker->units}}</a>
			</td>
		    </tr>
		    @endforeach
		</tbody>
	    </table>
	    <div>
		<button class="btn btn-md btn-ol-login" value="Сохранить" id="save_panel_markers_btn"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Загрузка...">Загрузить данные</button>
                <button type="button" class="btn btn-md btn-ol-cancel" data-dismiss="modal" aria-label="Close">Закрыть</button>
	    </div>
	    <input type="hidden" value="{{$oPanel->id}}" name="id" />
	    <input type="hidden" value="{{$oUser->id}}" name="user_id" />
	    </form>
        </div>
    </div>
</div>
</div>

<!-- Modal for add markers button. -->
<div id="add-file-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Добавление файла данных</h4>
	</div>
	<div class="modal-body">
	    <form id="add_file_form">
		<input id="input-data-file" name="input-data-file" type="file" class="file-loading" data-preview-file-type="pdf">
	    </form>
        </div>
    </div>
</div>
</div>

<!-- Modal for add file for marker. -->
<div id="add-marker-file-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Добавление файла для качественного маркера <span id="marker_name"></span></h4>
	</div>
	<div class="modal-body">
	    <form>
		<input id="input-data-marker-file" name="input-data-marker-file" type="file" class="file-loading">
	    </form>
        </div>
    </div>
</div>
</div>

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="col-md-8 my-markers-header">
	    {!! $oPanel->name !!}
	</div>
	<div class="col-md-8 tabs">
	    <a class="btn btn-md btn-panel-tab-not-active" value="О панели" id="save_profile_btn" href="/panel/{{$oPanel->id}}">О панели</a>
	    <a class="btn btn-md btn-panel-tab" value="Маркеры и трактовка" id="save_profile_btn" href="/panel/markers/{{$oPanel->id}}">Маркеры и трактовка</a>
	    
	</div>
	<div class="col-md-8">
	    Ниже вы можете добавить результаты своих анализов, внести их вручную.
	</div>
	<div class="col-md-8">
	    &nbsp;
	</div>
	<div class="col-md-8">
	    <a class="btn btn-md btn-ol-login" href="#" id="add_pdf_series">Выбрать PDF файл</a>
	    <a class="btn btn-md btn-ol-login" href="#" id="add_panel_series">Внести показания вручную</a>
	</div>
	<div class="col-md-8">
	    &nbsp;
	</div>
	<div class="col-md-8 my-markers-header">
	    Анализы по панели
	</div>
	<div class="col-md-8">
	    <table class="table">
		<thead>
		    <tr class="table-header">
			<th>
			    Название
			</th>
			<th>
			    Референс
			</th>
			@foreach($aSeries as $oSeries)
			    <th>
				@if ($aRes[$oSeries->id]['interpretation_file'])
				    <a href="/files/interpretation/{{$oSeries->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
				@endif
				{{$aRes[$oSeries->id]['date']}}
			    </th>
			@endforeach
		    </tr>
		</thead>
		<tbody>
		    @foreach($oPanel->getMarkers() as $oMarker)
		    <tr>
			<td>
			    <a href="/markers/marker/{{$oMarker->id}}">{{$oMarker->name}}</a>
			</td>
			<td>
			    @foreach($oMarker->refs($oPanel->id) as $oRef)
				{{$oRef->toString($oMarker->units)}} <br />
			    @endforeach
			</td>
			@foreach($aSeries as $oSeries)
			    @if (isset($aRes[$oSeries->id]['markers'][$oMarker->id]))
			    <td
					@php
					    switch ($aRes[$oSeries->id]['markers'][$oMarker->id]->checkRef($oPanel->id)) {
						case 0:
						    echo 'class="marker-success"';
						    break;
						case 1:
						    echo 'class="marker-fail"';
						    break;
					    }
					@endphp
			    >
				@if ($aRes[$oSeries->id]['markers'][$oMarker->id]->data_file)
				    <a href="/files/marker/{{$aRes[$oSeries->id]['markers'][$oMarker->id]->id}}">Файл</a>
				    (<a href="#" class="add_marker_file" data-series-id="{{$oSeries->id}}" data-marker-id="{{$oMarker->id}}" data-marker-name="{{$oMarker->name}}" data-user-marker-id="{{$aRes[$oSeries->id]['markers'][$oMarker->id]->id}}">заменить</a>)
				@else
				    {{$aRes[$oSeries->id]['markers'][$oMarker->id]->value}} <span title="{{$oMarker->units_full}}">{{$oMarker->units}}</span>
				@endif
			    </td>
			    @elseif ($oMarker->is_quality == 1)
				<td>
				    <a href="#" class="add_marker_file" data-series-id="{{$oSeries->id}}" data-marker-id="{{$oMarker->id}}" data-marker-name="{{$oMarker->name}}">Добавить файл</a>
				</td>
			    @else
				<td></td>
			    @endif
			@endforeach
		    </tr>
		    @endforeach
		</tbody>
	    </table>
	</div>
    </div>
</div>
@endsection

