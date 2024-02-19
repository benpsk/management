<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">

	<!-- CSRF Token -->
	<meta content="{{ csrf_token() }}" name="csrf-token">

	<title>{{ config("app.name", "Laravel") }}</title>

	<!-- Fonts -->
	<link href="//fonts.gstatic.com" rel="dns-prefetch">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<script src="{{ asset("js/app.js") }}" async></script>
	<script src="https://unpkg.com/htmx.org@1.9.10" integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC" crossorigin="anonymous"></script>

	@vite(["resources/css/app.css", "resources/js/app.js"]);
</head>

<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
			<div class="container">
				<a class="navbar-brand" href="{{ url("/") }}">
					Company Management Systems
				</a>
				{{-- Begin Right Collapse Navbar --}}
				<div class="border-left ml-auto" id="navbarSupportedContent">

					<!-- Right Side Of Navbar -->
					<ul class="m-0 p-0" style="list-style-type: none;">
						<!-- Authentication Links -->
						@guest
							@if (Route::has("login"))
								<li class="nav-item">
									<a class="nav-link" href="{{ route("login") }}">{{ __("Login") }}</a>
								</li>
							@endif
						@else
							<li class="nav-item dropdown">
								<a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown"
									href="#" id="navbarDropdown" role="button" v-pre>
									{{ Auth::user()->name }}
								</a>

								<div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="{{ route("logout") }}"
										onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
										{{ __("Logout") }}
									</a>

									<form action="{{ route("logout") }}" class="d-none" id="logout-form" method="POST">
										@csrf
									</form>

								</div>
							</li>
						@endguest
					</ul>
				</div>
				{{-- End of Right side Nab bar --}}
			</div>
		</nav>

		@auth
			<aside class="container py-3">
				<nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link {{ set_active("home") }} {{ set_active("/") }} {{ set_active("company*") }}"
							href="{{ route("home") }}" id="nav-home1-tab">Company</a>
						<a class="nav-item nav-link {{ set_active("employee*") }}" href="{{ route("employee.index") }}"
							id="nav-home-tab">Employee</a>
					</div>
				</nav>
			</aside>
		@endauth

		<main class="">
			@yield("content")
		</main>

	</div>

	@yield("script-after")
	<script>
		console.log('app.blade');
		$(function() {
			Echo.channel(`company`)
				.listen('CompanyCreated', (e) => {
					console.log(e);
					alert(e.company.name + " has been created");
				})
		});
	</script>
</body>

</html>
