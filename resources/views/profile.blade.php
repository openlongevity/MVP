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
	    <img src="{{$oUser->avatar}}" class="img-circle" alt="" height="150" width="150"/>
	</div>
        <div class="col-md-10">
	    <div class="profile-full-name">{{$oUser->getName()}}</div>
	    <div class="">{{$oUser->profile_location_birth}}</div>
	</div>
    </div>
</div>
@endsection

