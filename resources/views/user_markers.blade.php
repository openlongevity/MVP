@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <script type="text/javascript">
	var olManager = new ol.manager();
	jQuery(function($) {
	    $(document).ready( function () {
		$(document).on("click", "#save_profile_btn", function(e) {
		});

	    });
	});

    </script>
@endsection

@section('content')
<div class="container profile-content">
    <div class="row mymarkers-row">
	<h3>Мои маркеры</h3>
	@if (!count($markers))
	    Вы пока не добавили ни одного анализа
	@endif
    </div>
</div>
@endsection


