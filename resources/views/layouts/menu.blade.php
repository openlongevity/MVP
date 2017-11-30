<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="{{ asset('css/ol.css') }}" rel="stylesheet">
</head>
<body>
     <div id="app">
		<div class="collapse navbar-collapse" id="app-navbar-collapse">
		    <ul class="nav navbar-nav navbar-right">
                            <li class="right-menu-profile-link">
                                <a href="/profile">
                                    <span class="right-link">{{ Auth::user()->getShortName() }}</span> <img src="{{$oUser->getAvatarLink()}}" class="img-circle" alt="" height="35" width="35"/>
				</a>

			    </li>
			    <li>
				<img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-circle logout-left" alt="" height="35" width="0"/>
			    </li>
                            <li class="btn-logout">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
						<span class="right-link">Выход</span><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" class="img-circle" alt="" height="35" width="0"/>
					</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
			    </li>
		    </ul>
		</div>
		<hr class="top-menu-hr"/>

	<div class="row main-row">
	    <div class="col-md-2">
		<div class="nav-side-menu">

		    <div class="brand"><img src="/images/logo_white_nobg.png" height="70px"/></div>
		    <div class="version">V 0.1 BETA</div>
		    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
		    
		    <div class="menu-list">
			<ul id="menu-content" class="menu-content collapse out">
			    <li id="profile_link">
				<a href="/profile">Профиль</a>
			    </li>
			    <li  id="my_markers_link">
				<a href="/my_markers">Мои маркеры</a>
			    </li>  
			    <li id="panel_ol11_link">
				<a href="/panel_ol11">Панель OL 1.1</a>
			    </li>  
			</ul>
		    </div>
		</div>
	    </div>
	    
	    <div class="col-md-10">
		@yield('content')
	    </div>
	</div>
    </div>
    <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script type="text/javascript">
	jQuery(function($) {
	    $(document).ready( function () {
		// Set active class
		$('#{{$active}}').addClass('active');	
		
		$(document).on("click", "#profile_link", function(e) {
		    location.href = '/profile';
		});
		$(document).on("click", "#my_markers_link", function(e) {
		    location.href = '/my_markers';
		});
		$(document).on("click", "#panel_ol11_link", function(e) {
		    location.href = '/panel_ol11';
		});


	    });
	});

    </script>
    @yield('js')

</body>
</html>


