<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GroomRoom</title>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

	@yield('logo')

	<header>
		<div class="content">
			<nav>
				@if($role == "guest")
					<a href="/#login">Войти</a> |
					<a href="/#register">Регистрация</a>
				@endif
				@if($role != "guest")
					<a href="{{ route('main_page') }}">Главная</a> |
				@if($role == "admin")
					<a href="{{ route('groom_page') }}">Заявки</a> |
				@endif
					<a href="{{ route('user_page') }}">Личный кабинет</a> |
					<a class="test-b-logout" href="{{ route('logout') }}">Выход</a>
				@endif
			</nav>
		</div>
	</header>

	<main>
		<div class="content">
			@yield('content')
		</div>
	</main>

	<footer>
		<div class="content">
			Сайт выполнен в качестве подготовки к отборочным WSR 2021
		</div>
	</footer>

	<div class="mask"></div>
	
</body>
</html>