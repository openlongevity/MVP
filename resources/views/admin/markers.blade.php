@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' />
    <script type='text/javascript' src='https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

    <script type="text/javascript">
	var olManager = new ol.manager();
	var markerIdForDelete = undefined;
	jQuery(function($) {
	    $(document).ready( function () {

		$('#markers').DataTable({
                    "iDisplayLength": 100,
		    columnDefs: [
                        { targets: 'no-sort', orderable: false }
                    ],

                 });
		
		$(document).on("click", ".remove_marker", function(e) {
		    // show confirm delete modal
		    $('#confirm-delete').modal();
		    markerIdForDelete = $(this).attr('data-marker-id');
		    e.preventDefault();
		    return false;
		});
		$(document).on("click", "#delete-marker-forever", function(e) {
		    olManager.deleteMarker(markerIdForDelete);
		    e.preventDefault();
		    return false;
		});
	    });
	});

    </script>
@endsection

@section('content')

<!-- Modal for deleting marker. -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Вы действительно хотите удалить данный маркер? Внимание! Все анализы пользователей добавленные для этого маркера будут также удалены!
            </div>
	    <div class="modal-footer">
                <button type="button" class="btn  btn-md btn-ol-cancel" data-dismiss="modal">Отмена</button>
                <a class="btn  btn-md btn-ol-delete" id="delete-marker-forever">Удалить</a>
            </div>
        </div>
    </div>
</div>

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Маркеры
	</div>
	    @include('admin/markers_table', [])
    </div>
</div>
@endsection


