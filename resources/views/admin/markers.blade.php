@extends('layouts.menu')

@section('js')
    <script src="{{ asset('js/ol.js') }}"></script>
    <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' />
    <script type='text/javascript' src='https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>

    <script type="text/javascript">
	jQuery(function($) {
	    $(document).ready( function () {

		$('#markers').DataTable({
                    "iDisplayLength": 100,
		    columnDefs: [
                        { targets: 'no-sort', orderable: false }
                    ],

                 });
 
	    });
	});

    </script>
@endsection

@section('content')

<div class="profile-content">
    <div class="mymarkers-row">
	<div class="my-markers-header">
	    Маркеры
	</div>
	    @include('admin/markers_table', [])
    </div>
</div>
@endsection


