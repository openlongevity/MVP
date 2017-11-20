@extends('layouts.menu')

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
<div class="container profile-content">
    <div class="row profile-row">
        <div class="col-md-2">
	    <img src="{{$oUser->getAvatarLink()}}" class="img-circle" alt="" height="150" width="150"/>
	</div>
        <div class="col-md-6">
		<div class="profile-full-name">
		    {{$oUser->getName()}}
		</div>
		<div class="">{{$oUser->profile_location_birth}}</div>
		<div class="">{{$oUser->birthday}}, {{$oUser->getAges()}}</div>
	    <div class="">&nbsp;</div>
	    <div class="">&nbsp;</div>
	    <div>
            <form name="form" id="user-profile-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">ФИО*</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <input id="name" autocomplete="off" type="email" name="name" 
				value="{{$oUser->name}}" class="edit_profile_input">
                                @if ($errors->has('profile_first_name'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_first_name') }}
                                    </span>
                                @endif
                    </div>
                </div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-6">
			<span class="profile_cell_name">Пол*</span>
		    </div>
                    <div class="col-xs-6">
			<span class="profile_cell_name">Дата рождения*</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-6 b-select-wrap">
			<select class="b-select" name="gender">
			    <option value="0" @if ($oUser->gender == 0) selected @endif>Мужской</option>
			    <option value="1" @if ($oUser->gender == 1) selected @endif>Женский</option>
			</select>
		    </div>
                    <div class="col-xs-6">
			    <input id="name" autocomplete="off" type="text" name="birthday" 
				value="{{$oUser->birthday}}" class="edit_profile_input">
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                        {{ $errors->first('birthday') }}
                                    </span>
                                @endif
		    </div>
		</div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">Рост, см.*</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <input autocomplete="off" type="text" name="profile_height" 
				value="{{$oUser->profile_height}}" class="edit_profile_input_short">
                                @if ($errors->has('profile_height'))
                                    <span class="help-block">
                                        {{ $errors->first('profile_height') }}
                                    </span>
                                @endif
                    </div>
                </div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-6">
			<span class="profile_cell_name">Семейное положение</span>
		    </div>
                    <div class="col-xs-6">
			<span class="profile_cell_name">Дети</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-6 b-select-wrap">
			<select class="b-select" name="profile_marital_status">
			    @foreach ($oUser->getMaritalStatuses() as $key => $value)
				<option value="{{$key}}" @if ($oUser->profile_marital_status == $key) selected @endif>{{$value}}</option>
			    @endforeach
			</select>
		    </div>
                    <div class="col-xs-6 b-select-wrap">
			<select class="b-select" name="profile_children">
			    <option value="0" @if ($oUser->profile_children == 0) selected @endif>Нет</option>
			    @for ($i = 1; $i < 11; $i++)
				<option value="{{$i}}" @if ($oUser->profile_children == $i) selected @endif>{{$i}}</option>
			    @endfor
			</select>
		    </div>
		</div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">Укажите место рождения</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <input  autocomplete="off" type="text" name="profile_location_birth" 
				value="{{$oUser->profile_location_birth}}" class="edit_profile_input">
                    </div>
                </div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">Укажите место проживания</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <input  autocomplete="off" type="text" name="profile_location" 
				value="{{$oUser->profile_location}}" class="edit_profile_input">
                    </div>
                </div>
                <div>
		    &nbsp;
		</div>
                <div class="row">
                    <div class="col-xs-12">
                            <span class="profile_cell_name">О себе</span>
		    </div>
		</div>
                <div class="row">
                    <div class="col-xs-12">
			    <textarea  autocomplete="off" type="text" name="profile_about" 
				value="{{$oUser->profile_about}}" class="edit_profile_input_textarea">{{$oUser->profile_about}}</textarea>
                    </div>
                </div>
                <div>
		    &nbsp;
		</div>
		<div class="row">
		    <div class="col-xs-12">
			<button class="btn btn-md btn-ol-login" value="Сохранить" id="save_profile_btn"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Сохранение...">Сохранить изменения</button>
                        <a class="btn btn-md btn-ol-cancel" href="/profile">Отмена</a>
		    </div>
                </div>
            </form>
	    </div>
	</div>
        <div class="col-md-4">
	    &nbsp;
	</div>
    </div>
</div>
@endsection


