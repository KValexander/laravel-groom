@extends("shablon")

@section("logo")
	<div class="logo">
		<div class="content">
			<div class="image">
				<img class="test-t-logo" src="{{ asset('images/logo_groom.png') }}" />
			</div>
			<div class="text">
				<h1>PRETTY PAWFECT</h1>
				<h3>GROOMING SALON</h3>
			</div>
		</div>
	</div>
@endsection

@section("content")

	<div class="message">{{ $errors->message->first() }}</div>

	<div class="heading"> Последние оказанные услуги </div>
	<div class="container">
		@if(count($data->applications) == 0)
			<h3>Оказанные услуги отсутствуют</h3>
		@else
			@foreach($data->applications as $val)
				<div class="wrap">
					<img class="test-t-photo" src="{{ asset($val->path_to_image) }}" alt="">
					<h3 class="test-t-name">{{ $val->nickname }}</h3>
				</div>
			@endforeach
		@endif
	</div>

	<br><div id="register" class="heading"> Регистрация </div>

	<form action="{{ route('register') }}" method="GET">

		<p class="test-1-e-fio error">{{ $errors->register->first('fio') }}</p>
		<p><input class="test-1-i-fio" type="text" placeholder="ФИО" name="fio" ></p>

		<p class="test-1-e-login error">{{ $errors->register->first('login') }}</p>
		<p><input class="test-1-i-login" type="text" placeholder="Логин" name="login" ></p>

		<p class="test-1-e-email error">{{ $errors->register->first('email') }}</p>
		<p><input class="test-1-i-email" type="text" placeholder="Email" name="email" ></p>

		<p class="test-1-e-pass error">{{ $errors->register->first('password') }}</p>
		<p><input class="test-1-i-pass" type="password" placeholder="Пароль" name="password" ></p>

		<p class="test-1-e-pass2 error">{{ $errors->register->first('password_pass') }}</p>
		<p><input class="test-1-i-pass2" type="password" placeholder="Подтверждение пароля" name="password_pass" ></p>

		<p class="test-1-e-agree error">{{ $errors->register->first('privacy') }}</p>
		<div class="left">
			<p>
				<input class="test-1-i-agree" type="checkbox" name="privacy" />
				Согласие на обработку <a href="" class="link">персональных данных</a>
			</p>
		</div>

		<p><input class="test-1-b-reg" type="submit" value="Зарегистрироваться"></p>

	</form>

	<br><div id="login" class="heading"> Авторизация </div>

	<form action="{{ route('login') }}" method="GET">
		<p class="error">{{ $errors->login->first() }}</p>

		<p class="test-2-e-login error">{{ $errors->auth->first('login') }}</p>
		<p><input class="test-2-i-login" type="text" name="login" placeholder="Логин"></p>

		<p class="test-2-e-pass error">{{ $errors->auth->first('login') }}</p>
		<p><input class="test-2-i-password" type="password" name="password" placeholder="Пароль"></p>
		
		<p><input class="test-2-b-log" type="submit" value="Войти"></p>
	</form>

@endsection