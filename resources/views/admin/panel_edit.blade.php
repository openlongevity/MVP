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

	    });
	});

    </script>
@endsection

@section('content')

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
				value="{{$oUser->profile_about}}" class="summernote">{{$oPanel->description}}</textarea>
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
    </div>
</div>
@endsection

