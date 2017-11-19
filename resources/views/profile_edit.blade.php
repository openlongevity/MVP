@extends('layouts.app')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <script type="text/javascript">
	var olManager = new ol.manager();
	jQuery(function($) {
	    $(document).ready( function () {
		$(document).on("click", "#save_profile_btn", function(e) {
		    olManager.saveProfile();
		    e.preventDefault();
		    return false;
		});

	    });
	});

    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">profile</div>

                <div class="panel-body">

            <form name="form" id="user-profile-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="profile_first_name">Имя</label>
			    <input id="profile_first_name" autocomplete="off" type="email" name="profile_first_name" 
				value="{{$oUser->profile_first_name}}">
			    <p class="error-block">
			    </p>
                                @if ($errors->has('profile_first_name'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_first_name') }}
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="profile_middle_name">Отчество</label>
			    <input id="profile_middle_name" autocomplete="off" type="text" name="profile_middle_name" 
				value="{{$oUser->profile_middle_name}}">
			    <p class="error-block">
			    </p>
                                @if ($errors->has('profile_middle_name'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_middle_name') }}
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group floating-labels">
                            <label for="profile_second_name">Фамилия</label>
                            <input id="profile_second_name" autocomplete="off" type="email" name="profile_second_name"
				value="{{$oUser->profile_second_name}}">
			    <p class="error-block">
			    </p>
                                @if ($errors->has('profile_second_name'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_second_name') }}
                                    </span>
                                @endif
                        </div>
                    </div>
                </div>
		<div class="row">
		    <div class="col-xs-12">
			<button class="btn btn-xs btn-ol-login" value="Сохранить" id="save_profile_btn"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Сохранение...">Сохранить</button>
		    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


