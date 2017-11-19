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
        <div class="col-md-10">
		<div class="profile-full-name">
		    {{$oUser->getName()}}
		    <a class="btn btn-xs btn-ol-edit" href="/profile/edit">Редактировать</a>
		</div>
		<div class="">{{$oUser->profile_location_birth}}</div>
		<div class="">{{$oUser->birthday}}, {{$oUser->getAges()}}</div>
	    </div>
	    <div class="">&nbsp;</div>
	    <div class="">&nbsp;
		<table class="profile_table">
		    <tr class="profile_row_info">
			<td class="profile_cell_name">Пол:</td>
			<td>@if ($oUser->sex == 0) Мужской @else Женский @endif</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Рост:</td>
			<td>{{$oUser->profile_height}} см.</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Семейное положение:</td>
			<td></td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Дети:</td>
			<td>@if ($oUser->profile_children == 0) Нет @else {{$oUser->profile_children}} @endif</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Место рождения:</td>
			<td>{{$oUser->profile_location_birth}}</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Место проживания:</td>
			<td>{{$oUser->profile_location}}</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name"></td>
			<td></td>
		    </tr>
		    <tr>
			<td class="profile_cell_name"></td>
			<td></td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">О себе:</td>
			<td></td>
		    </tr>
		</table>
	    </div>
	</div>
    </div>
</div>
@endsection

