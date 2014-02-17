<!doctype html>
<html lang="da">
	<head>
		<meta charset="utf-8">
		<title>sletenlov.nu</title>
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" type="text/css" />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" type="text/css" />
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js" type="application/js"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 25px">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<nav class="navbar navbar-default navbar-inverse" role="navigation">
						<div class="navbar-header">
							 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="{{ URL::to('/') }}">sletenlov.<b>nu</b> <span class="fa fa-legal"></span></a>
						</div>
						
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li {{ Request::is('/') ? 'class="active"' : '' }}>
									<a href="{{ URL::to('/') }}">Hjem</a>
								</li>
								<li {{ Request::is('yolo') ? 'class="active"' : '' }}>
									<a href="#">Stem på en lov</a>
								</li>
								<li {{ Request::is('swag') ? 'class="active"' : '' }}>
									<a href="#">Stem på et lovforslag</a>
								</li>
								<li {{ Request::is('about') ? 'class="active"' : '' }}>
									<a href="{{ URL::to('about') }}">Om</a>
								</li>
							</ul>
							<form class="navbar-form navbar-right" role="search">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Søg i databasen" />
								</div> <button type="submit" class="btn btn-default">Søg</button>
							</form>
							<ul class="nav navbar-nav navbar-right">
								<li>
									@if(Auth::check())
										<a href="{{ URL::to('logout') }}">Log ud</a>
									@else
										<a href="{{ URL::to('login') }}">Log ind</a>
									@endif
								</li>
							</ul>
							@if(Auth::check())
								<p class="navbar-text navbar-right">Hej, {{ Auth::user()->name }}</p>
							@endif
						</div>
					</nav>

					@yield('content')

					<p class="text-muted text-center">
						<strong>{{ Section::count() }}</strong> paragraffer indekseret<br />
						Lavet for <a href="http://internetpartiet.dk/">Internetpartiet.dk</a> 2014 | Programmeret af <a href="http://nordbjerg.net/">nordbjerg.net</a>
					</p>
				</div>
			</div>
		</div>
	</body>
</html>
