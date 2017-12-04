@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

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
		<thead>
		    <tr>
			<th>
			</th>
			<th>
			</th>
			<th>
			</th>
		    </tr>
		</thead>
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
			    {{$marker->units}}
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
	    <a class="btn btn-md btn-ol-login" href="#" id="add_panel_series">Внести показания вручную</a>
	</div>
	<div class="col-md-8">
	    &nbsp;
	</div>
	<div class="col-md-8">
	    <table class="table">
		<thead>
		    <tr>
			<td>
			</td>
			@foreach($aSeries as $oSeries)
			    <td>
				{{$aRes[$oSeries->id]['date']}}
			    </td>
			@endforeach
		    </tr>
		</thead>
		<tbody>
		    @foreach($oPanel->getMarkers() as $oMarker)
		    <tr>
			<td>
			    {{$oMarker->name}}
			</td>
			@foreach($aSeries as $oSeries)
			    <td>
				@if (isset($aRes[$oSeries->id]['markers'][$oMarker->id]))
				    {{$aRes[$oSeries->id]['markers'][$oMarker->id]->value}} {{$oMarker->units}}
				@endif
			    </td>
			@endforeach
		    </tr>
		    @endforeach
		</tbody>
	    </table>
	</div>
    </div>
</div>
@endsection

