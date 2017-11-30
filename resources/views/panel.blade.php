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
		});

	    });
	});

    </script>
@endsection

@section('content')

<div class="container profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Панель Open Longevity 1.1
	</div>
    </div>
</div>
@endsection



