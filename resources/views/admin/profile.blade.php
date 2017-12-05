@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <script type="text/javascript">
	jQuery(function($) {
	    $(document).ready( function () {
	    });
	});

    </script>
@endsection

@section('content')
<div class="profile-content">
    <div class="row profile-row">
        <div class="col-md-2">
	    <img src="{{$oProfileUser->getAvatarLink()}}" class="img-circle" alt="" height="150" width="150"/>
	</div>
        <div class="col-md-10">
		<div class="profile-full-name">
		    {{$oProfileUser->getName()}}
		</div>
		<div class="">{{$oProfileUser->profile_location_birth}}</div>
		<div class="">{{$oProfileUser->birthday}}, {{$oProfileUser->getAges()}}</div>
	    <div class="">&nbsp;</div>
	    <div class="">&nbsp;</div>
	    <div class="">
		<table class="profile_table">
		    <tr class="profile_row_info">
			<td class="profile_cell_name">Пол:</td>
			<td>@if ($oProfileUser->gender == 0) Мужской @else Женский @endif</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Рост:</td>
			<td>{{$oProfileUser->profile_height}} см.</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Семейное положение:</td>
			<td>{{$oProfileUser->getMaritalStatus()}}</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Дети:</td>
			<td>@if ($oProfileUser->profile_children == 0) Нет @else {{$oProfileUser->profile_children}} @endif</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Место рождения:</td>
			<td>{{$oProfileUser->profile_location_birth}}</td>
		    </tr>
		    <tr>
			<td class="profile_cell_name">Место проживания:</td>
			<td>{{$oProfileUser->profile_location}}</td>
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
	    <div class="profile_about">{{$oProfileUser->profile_about}}</div>
	</div>
    </div>
</div>
@endsection


