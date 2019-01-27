<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> ChrisList </title>
		<meta name="description" content="">
		<meta name="author" content="">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}"/>

		<!-- Basic Styles -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/bootstrap.min.css') }}">
	    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/font-awesome.min.css') }}">

		<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/smartadmin-production.css') }}">
    	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/plugins/smartadmin/css/smartadmin-skins.css') }}">
		
    	<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('/css/override.css') }}">

		<link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon">
    	<link rel="icon" href="/img/favicon/favicon.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

	</head>
	<body id="login">
		<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
		<header id="header">
			<!--<span id="logo"></span>-->

			<div id="logo-group">
				<span id="logo"> <img src="/img/logo.png" alt="ChrisList"> </span>

				<!-- END AJAX-DROPDOWN -->
			</div>

			@if(Request::path() == 'auth/register' || Request::path() == 'register')
	        	<span id="login-header-space"> <span class="hidden-mobile">Already registered?</span> <a href="/auth/login" class="btn btn-danger">Sign In</a> </span>
	        @elseif(Request::path() == 'auth/login' || Request::path() == 'login')
	        	<span id="login-header-space"> <span class="hidden-mobile">Need an account?</span> <a href="/auth/register" class="btn btn-danger">Create Account</a> </span>
		    @endif			

		</header>

		<div id="main" role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">
				@yield('content')				
			</div>

		</div>

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>-->

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	    
	    <script>
	      if (!window.jQuery) {
	        document.write('<script src="/plugins/smartadmin/js/libs/jquery-2.0.2.min.js"><\/script>');
	      }
	    </script>

	    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	    <script>
	      if (!window.jQuery.ui) {
	        document.write('<script src="/plugins/smartadmin/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
	      }
	    </script>

		<!-- BOOTSTRAP JS -->		
		<script src="{{ asset('/plugins/smartadmin/js/bootstrap/bootstrap.min.js') }}"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="{{ asset('/plugins/smartadmin/js/notification/SmartNotification.min.js') }}"></script>

		<!-- JARVIS WIDGETS -->
		<script src="{{ asset('/plugins/smartadmin/js/smartwidgets/jarvis.widget.min.js') }}"></script>
		
		<!-- SPARKLINES -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>
		
		<!-- JQUERY VALIDATE -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>
		
		<!-- JQUERY SELECT2 INPUT -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/select2/select2.min.js') }}"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
		
		<!-- browser msie issue fix -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>
		
		<!-- FastClick: For mobile devices -->
		<script src="{{ asset('/plugins/smartadmin/js/plugin/fastclick/fastclick.js') }}"></script>
		
		<!--[if IE 7]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->

		@if(Request::path() == 'auth/register' || Request::path() == 'register')
        	<script type="text/javascript" src="{{ asset('/js/pages/auth/register.js?version=1.1.0') }}"></script>
        @elseif(Request::path() == 'auth/login' || Request::path() == 'login')
        	<script type="text/javascript" src="{{ asset('/js/pages/auth/login.js?version=1.1.0') }}"></script>
	    @endif

	</body>
</html>