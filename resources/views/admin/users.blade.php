@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' />
    <script type='text/javascript' src='https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

    <script type="text/javascript">
	jQuery(function($) {
	    $(document).ready( function () {

		$('#users').DataTable({
                    "iDisplayLength": 100,
                 });
 
	    });
	});

    </script>
@endsection

@section('content')

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Пользователи
	</div>
	    @include('admin/users_table', [])
    </div>
</div>
@endsection

