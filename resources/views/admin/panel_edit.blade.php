@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.js"></script>
    <script src="{{ asset('js/notify.js') }}"></script>

    <script type="text/javascript">
	var olManager = new ol.manager();
	var markerIdForDelete = undefined;
	var markerIdForRef = undefined;
	jQuery(function($) {
	    $(document).ready( function () {
		$('.summernote').summernote({
                    height:500,
                    callbacks: {
                        onImageUpload: function(image) {
                            if ($('#id').val()) {
                                ol.utils.uploadImage(image[0], $(this), $('#id').val());
                            } else {
                                $('#upload-error-modal').modal();
                            }
                        }
                    },
                });



		$(document).on("click", "#save_panel_btn", function(e) {
		    olManager.savePanelInfo();
		    e.preventDefault();
		    return false;
		});

		
		$('#marker_chooser').select2({
		});

		$(document).on("change", "#marker_chooser", function(e) {
		    $('#marker_name').html($("#marker_chooser option:selected").text());
		    $('#confirm-add').modal();
		});
		
		$(document).on("click", "#add-marker-to-panel", function(e) {
		    olManager.addMarkerToPanel();
		    e.preventDefault();
		    return false;
		});

		
		$(document).on("click", ".remove_marker", function(e) {
		    // show confirm delete modal
		    $('#confirm-delete').modal();
		    markerIdForDelete = $(this).attr('data-marker-id');
		    e.preventDefault();
		    return false;
		});
		$(document).on("click", "#delete-marker-from-panel", function(e) {
		    olManager.deleteMarkerFromPanel(markerIdForDelete);
		    e.preventDefault();
		    return false;
		});
		
		$(document).on("click", ".edit_marker_reference", function(e) {
		    // Show modal.
		    $('#edit-references').modal();
		    
		    // Add name of marker to modal
		    var id = $(this).attr('data-marker-id');
		    markerIdForRef = id;
		    $('#marker_name_ref').html($('#marker_name_'+id).text());

		    // Add units to modal.
		    $('#marker_units_ref').html($(this).attr('data-marker-units'));

		    // Get table from server.
		    olManager.getTableReference(id, $('#id').val());
		    
		    e.preventDefault();
		    return false;
		});
		
		$(document).on("click", ".add_ref_marker", function(e) {
		    // Find "free" index.
		    var index = 0;	
		    while(1) {
			if (!$("#ref_row_" + index).length) {
			    break;
			}

			index++;
			if (index > 100) {
			    break;
			}
		    }
		    console.log('index:' + index);

		    // Add row with empty data about index.
		    olManager.createRowReference(index);
			
		    e.preventDefault();
		    return false;
		});
		
		$(document).on("change", ".select-age", function(e) {
		    var index = $(this).attr('data-index');
		    if ($(this).val() == 1) {
			$('#select_age_div_' + index).show();
		    } else {
			$('#select_age_div_' + index).hide();
		    }
		});
		
		
		$(document).on("click", "#add-marker-references", function(e) {
		    var cRefs = $('#ref_marker tbody').find('tr').length;
		    var index = 0, findIndex = 0;
		    while(1) {
			if ($("#ref_row_" + index).length) {
			    findIndex++;	
			}

			index++;
			if (index > 100) {
			    break;
			}
			if (findIndex == cRefs) {
			    break;
			}
		    }
		    
		    olManager.updateReferences(index, markerIdForRef, $('#id').val());
			
		    e.preventDefault();
		    return false;
		});
		$(document).on("click", ".remove_ref_marker", function(e) {
		    var id = $(this).attr('data-marker-index');
		    $('#ref_row_' + id).remove();
		    e.preventDefault();
		    return false;
		});

	    });
	});

    </script>
@endsection

@section('content')

<!-- Modal for deleting marker from panel. -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Вы действительно хотите удалить данный маркер из панели?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-md btn-ol-cancel" data-dismiss="modal">Отмена</button>
                <a class="btn  btn-md btn-ol-delete" id="delete-marker-from-panel">Удалить</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding marker to panel. -->
<div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Добавить маркер "<span id='marker_name'></span>" в панель?
            </div>
            <div class="modal-footer">
                <button class="btn  btn-md btn-ol-login" id="add-marker-to-panel"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Добавление...">Да</button>
                <button type="button" class="btn  btn-md btn-ol-cancel" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing marker references. -->
<div class="modal fade" id="edit-references" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
		Редактирование референсных значений для маркера "<span id="marker_name_ref"></span>".
	    </div>
	    <div class="modal-body">
		<div>
		    Единицы измерения:  <span id="marker_units_ref"></span>
		</div>
		<div id="marker_content_ref">
		    <i class='fa fa-spinner fa-spin '></i> Подгрузка ...
		</div>
	    </div>
            <div class="modal-footer">
                <button class="btn  btn-md btn-ol-login" id="add-marker-references"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Добавление...">Сохранить</button>
                <button type="button" class="btn  btn-md btn-ol-cancel" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Редактирование панели
	</div>
	<div>
	    &nbsp;
	</div>
	<div>
            <form name="form" id="panel-form">
		{{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">Название*</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <input autocomplete="off" type="text" name="name" 
				value="{{$oPanel->name}}" class="edit_profile_input" required="required">
                                <span class="error-block" id="name-error">
                                </span>
                    </div>
                </div>
		<div>
		    &nbsp;
		</div>
		
		<div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">Описание</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <textarea  autocomplete="off" type="text" name="description" 
				class="summernote">{{$oPanel->description}}</textarea>
                    </div>
                </div>
		<div>
		    &nbsp;
		</div>
		<div class="row">
		    <div class="col-xs-12">
			<button class="btn btn-md btn-ol-login" value="Сохранить" id="save_panel_btn"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Сохранение...">Сохранить изменения</button>
                        <a class="btn btn-md btn-ol-cancel" href="/panel/{{$oPanel->id}}">Отмена</a>
		    </div>
		</div>
		<input type="hidden" name="id" value="{{$oPanel->id}}" id="id"/>
	    </form>
	</div>
	<div>
	    &nbsp;
	</div>
	<div>
	    &nbsp;
	</div>
	<div class="my-markers-header">
	    Список маркеров панели
	</div>
	<div>
	    <table class="table" id="panel_markers">
		<thead>
		    <tr>
			<th>Название</th>
			<th>Референсы панели</th>
			<th></th>
		    </tr>
		</thead>
		<tbody>
		@foreach($oPanel->getMarkers() as $oMarker)
		    @include('admin/panel_edit_marker_row', [$oMarker])
		@endforeach
		    <tr>
			<td>
			    <select name="new_marker_id" class="marker_id js-example-basic-single markers_select_for_panel" id="marker_chooser">
				<option value="0">Выберите маркер для добавления в панель</option>
				@foreach($allMarkers as $marker) 
				    <option value="{{$marker->id}}">{{$marker->name}}</option>
				@endforeach
			    </select>
			</td>
			<td></td>
			<td></td>
		    </tr>
		</tbody>
		
	    </table>
	</div>
    </div>
</div>
@endsection

