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
	    $(document).ready( function () {

		$('#requests').DataTable({
                    "iDisplayLength": 100,
                 });
 
		$(document).on("click", ".add-interpretation-file", function(e) {
			var series_id = $(this).attr('data-series-id');
			$("#add-file-modal").modal();
                        $("#input-interpretation-file").fileinput({
                            overwriteInitial: false,
                            initialCaption: "Файл трактовки",
			    allowedFileExtensions: ['pdf'],
			    language: 'ru',
                            uploadUrl: '/admin/series/files/interpretation/add/' + series_id,
			    deleteUrl: '/admin/series/files/interpretation/delete/' + series_id,
			    ajaxSettings: { headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }},

                        });
			$('#input-interpretation-file').on('fileuploaded', function(event, data, previewId, index) {
			    location.href = '/admin/request/{{$oSeries->id}}';
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
<div id="add-file-modal" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <h4 class="modal-title">Добавление файла интерпретации</h4>
	</div>
	<div class="modal-body">
	    <form id="add_file_form">
		<input id="input-interpretation-file" name="input-interpretation-file" type="file" class="file-loading" data-preview-file-type="pdf">
		<input type="hidden" name="id" />
	    </form>
        </div>
    </div>
</div>
</div>

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Запрос на трактовку от пользователя <a href="/admin/users/profile/{{$oUserRequest->id}}">{{$oUserRequest->getName()}}</a>
	</div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Данные профайла</div>
	    <div class="">
		<table class="profile_table">
		    <tr>
			<td class="profile_cell_name">Возраст:</td>
			<td>{{$oUserRequest->getAges()}}</td>
		    </tr>
		    <tr class="profile_row_info">
			<td class="profile_cell_name">Пол:</td>
			<td>@if ($oUserRequest->gender == 0) Мужской @else Женский @endif</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Рост:</td>
			<td>{{$oUserRequest->profile_height}} см.</td>
		    </tr>
		</table>
	    </div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Введенные данные</div>
	    <div>
		@if ($oSeries->data_file)
		<div class="data-file">
		    <object data="/files/data/{{$oSeries->id}}" type="application/pdf" width="100%" height="100%">
			<p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="/files/data/{{$oSeries->id}}">Download PDF</a>.</p>
		    </object>
		</div>
		@else
		<div>
		    
	    <table class="table">
		<thead>
		</thead>
		<tbody>
		    @foreach($oPanel->getMarkers() as $oMarker)
		    <tr>
			<td>
			    {{$oMarker->name}}
			</td>
			    <td>
				@if (isset($aUserMarkers[$oMarker->id]))
				    {{$aUserMarkers[$oMarker->id]->value}} <span title="{{$oMarker->units_full}}">{{$oMarker->units}}</span>
				@endif
			    </td>
		    </tr>
		    @endforeach
		</tbody>
	    </table>
		</div>
		@endif
	    </div>
	    <div class="">&nbsp;</div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Дополнительные файлы</div>
	    <div class="">&nbsp;</div>
	    <div class="my-header-2">Файл трактовки</div>
	    <div>
		@if ($oSeries->interpretation_file)
		<div class="interpretation-file">
		    <a href="/files/interpretation/{{$oSeries->id}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
		    (<a href="#" class="add-interpretation-file" data-series-id="{{$oSeries->id}}">заменить</a>)
		    <object data="/files/interpretation/{{$oSeries->id}}" type="application/pdf" width="100%" height="100%">
			<p><b>Example fallback content</b>: This browser does not support PDFs. Please download the PDF to view it: <a href="/files/interpretation/{{$oSeries->id}}">Download PDF</a>.</p>
		    </object>
		</div>
		@else
		    <a href="#" class="add-interpretation-file" data-series-id="{{$oSeries->id}}">Добавить</a>
		@endif
	    </div>
    </div>
</div>
@endsection




