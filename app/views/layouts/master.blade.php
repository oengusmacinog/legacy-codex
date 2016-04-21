<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

		@if (isset($currentManual))
			<title>{{ Config::get('codex.site_name') }} - {{ $currentManual }} {{ $currentVersion }}</title>
		@else
			<title>{{ Config::get('codex.site_name') }}</title>
		@endif

		<!-- CSS -->
		<link rel="stylesheet" href="{{ asset('/assets/css/bootswatch/flatly.min.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/prettify/freshcut.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/nano.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/tocify.css') }}">
		<link rel="stylesheet" href="{{ asset('/assets/css/codex.css') }}">
	</head>
	<body>
		@include('partials.analytics_tracking')
		@include('partials.navbar')

		<div id="wrapper">
			@include('partials.sidebar')

			<div id="page-content-wrapper">
				<div class="container-fluid">
					<div class="row">
						@yield('content')
					</div>
				</div>
			</div>
		</div>

		<!-- Javascript -->
		<script src="{{ asset('/assets/js/jquery-2.1.1.min.js') }}"></script>
		<script src="{{ asset('/assets/js/jquery-ui-widget.min.js') }}"></script>
		<script src="{{ asset('/assets/js/jquery.nanoscroller.min.js') }}"></script>
		<script src="{{ asset('/assets/js/jquery.tocify.min.js') }}"></script>
		<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/assets/js/prettify/run_prettify.js') }}"></script>
		<script src="{{ asset('/assets/js/codex.js') }}"></script>
	</body>
</html>
