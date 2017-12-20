@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' />
    <script type='text/javascript' src='https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

    <link rel='stylesheet' type='text/css' href='{{asset("bootstrap-fileinput/css/fileinput.min.css")}}' />
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/fileinput.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/plugins/sortable.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/plugins/purify.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/themes/fa/theme.js")}}'></script>
    <script type='text/javascript' src='{{asset("bootstrap-fileinput/js/locales/ru.js")}}'></script>

    <script type="text/javascript">
	jQuery(function($) {
	    var olManager = new ol.manager();
	    $(document).ready( function () {

	    });
	});

    </script>
@endsection

@section('content')

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Маркер {{$oMarker->name}}
	</div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Название</div>
	    <div>
		{{$oMarker->name}}
	    </div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Синонимы (на русском)</div>
	    <div>
		{{$oMarker->names}}
	    </div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Синонимы (на английском)</div>
	    <div>
		{{$oMarker->names_en}}
	    </div>
	    
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Краткое описание</div>
	    <div>
		{{$oMarker->desc_short}}
	    </div>
	    
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Описание</div>
	    <div>
		{{$oMarker->desc}}
	    </div>

	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Единицы измерения</div>
	    <div>
		{{$oMarker->units}} ({{$oMarker->units_full}})
	    </div>

	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Метод</div>
	    <div>
		{{$oMarker->method}}
	    </div>

	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Биоматериал</div>
	    <div>
		{{$oMarker->biomaterial}}
	    </div>

	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Подготовка</div>
	    <div>
		{{$oMarker->preparing}}
	    </div>
    </div>
</div>
@endsection





