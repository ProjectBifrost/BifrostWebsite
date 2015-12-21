<!DOCTYPE html>
<html lang="en">
	@include('templates.partials.head')
	<body class="preload" onload="$('body').removeClass('preload')">
		@include('templates.partials.header')
		<main>
			@section('main')
				@include('templates.partials.alerts')
				@yield('content')
			@stop
			@yield('main')
		</main>
		@include('templates.partials.footer')
	</body>
</html>