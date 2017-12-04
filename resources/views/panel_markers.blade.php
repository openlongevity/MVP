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
		$(document).on("click", "#btn-add-markers", function(e) {
		});

	    });
	});

    </script>
@endsection

@section('content')

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
    </div>
</div>
@endsection

