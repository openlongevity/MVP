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
			    location.href = '/admin/requests/';
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
	    Анализы по панели (запросы на трактовку)
	</div>
	    @include('admin/requests_table', [])
    </div>
</div>
@endsection



