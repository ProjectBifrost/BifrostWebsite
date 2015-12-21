@section('description')
Project Bifrost
@stop

<head>
	<title>@yield('title') - Project Bifrost</title>

	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Terra Gaming Network">

	<meta name="description" content="@yield('description')">
	<meta name="keywords" conent="Terra, Gaming, Network, TGN, Project, Bifrost, Minecraft, OAuth, OAuth2, Provider, @yield('tags')">

	<link rel="shortcut icon" href="{{ asset('img/meta/favicon.png') }}">
	<link rel="stylesheet" href="{{ asset('css/core.css') }}">

	{{--<script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
	<script src="{{ asset('js/bootstrap.js') }}" type="text/javascript"></script>--}}
</head>