<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GroomRoom</title>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

	<!-- Точка для секции логотипа -->
	@yield('logo')

	<!-- Хедер -->
	<header>
		<div class="content">
			<nav>
				<!-- Если пользователь гость -->
				@if($role == "guest")
					<a href="/#login">Войти</a> |
					<a href="/#register">Регистрация</a>
				@endif
				<!-- Если пользователья не гость -->
				@if($role != "guest")
					<a href="{{ route('main_page') }}">Главная</a> |
					<!-- Если пользователья администратор -->
					@if($role == "admin")
						<a href="{{ route('groom_page') }}">Заявки</a> |
					@endif
					<a href="{{ route('user_page') }}">Личный кабинет</a> |
					<a class="test-b-logout" href="{{ route('logout') }}">Выход</a>
				@endif
			</nav>
		</div>
	</header>

	<!-- Контентная часть -->
	<main>
		<div class="content">
			<!-- Точка для секции контента -->
			@yield('content')
		</div>
	</main>

	<!-- Футер -->
	<footer>
		<div class="content">
			Сайт выполнен в качестве подготовки к отборочным WSR 2021
		</div>
	</footer>

	<!-- Маска для заднего фона -->
	<div class="mask"></div>
	
</body>
</html>