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
    <link href="{{ asset('css/ol.css') }}" rel="stylesheet">
    <link href="{{ asset('css/marino.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/1.0.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />

</head>
<body class="body-class">
    <div id="app">

        <div class="flex-center position-ref full-height">

	    <div class="logo">
		<img src="/images/logo_white_nobg.png" class="logo-start-page"/>
	    </div>
	    <div class="row">
	    </div>
	    <div class="slogan">
		Вас приветствует OpenLongevity - платформа <br /> продлевающая жизнь
	    </div>
	    <div class="row">
		&nbsp;
	    </div>
	    <div class="row">
		&nbsp;
	    </div>
            <div class="content">
		@yield('content')
	    </div>
    </div>

    <!-- Scripts -->
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script-->

<script src="/js/bower_components/jquery/dist/jquery.js"></script>
<script src="/js/bower_components/tether/dist/js/tether.js"></script>
<script src="/js/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="/js/bower_components/PACE/pace.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.0.0/lodash.min.js"></script>
<script src="/js/marino-scripts/components/jquery-fullscreen/jquery.fullscreen-min.js"></script>
<script src="/js/bower_components/jquery-storage-api/jquery.storageapi.min.js"></script>
<script src="/js/bower_components/wow/dist/wow.min.js"></script>

<script src="/js/marino-scripts/functions.js"></script>
<script src="/js/marino-scripts/colors.js"></script>
<script src="/js/marino-scripts/left-sidebar.js"></script>
<script src="/js/marino-scripts/navbar.js"></script>
<script src="/js/marino-scripts/horizontal-navigation-1.js"></script>
<script src="/js/marino-scripts/horizontal-navigation-2.js"></script>
<script src="/js/marino-scripts/horizontal-navigation-3.js"></script>
<script src="/js/marino-scripts/components/floating-labels.js"></script>
<script src="/js/marino-scripts/main.js"></script>
<script src="/js/marino-scripts/forms-sample.js"></script>

</body>
</html>

