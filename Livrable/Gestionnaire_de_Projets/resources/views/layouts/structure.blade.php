<!Doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<link rel="shortcut icon" type="image/x-icon" href="logo_dark.png" />
<title>ISOPROM: Gestionnaire de projets</title>

<link rel="shortcut icon" type="image/x-icon" href="..\logo_dark.png" />

	@include('partials._metas')
	@section('csss')<!--styles-->
		@include('partials._csss')
	@show

</head>
<body>

	@include('partials._mainMenu')<!--Menu-->

					<div class="container">

					@yield('content')

					</div>

		@include('partials._footer')<!--footer-->

	@section('jss')	<!--javaScripts-->
		@include('partials._jss')
	@show

</body>
</html>
<!--@if(session()->has('flash'))
<div class="container">
	<div class="alert alert-success">{{ session('flash') }}</div>
</div>
@endif-->
