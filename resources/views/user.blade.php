@extends("shablon")

@section("content")
	<!-- Див с выводом сообщений в случае их наличия -->
	<div class="message">{{ $errors->message->first() }}</div>

	<div class="heading">Ваши заявки</div>

	<div class="container">
		<!-- Если заявок нет -->
		@if(count($data->applications) == 0)
			<h3>Заявки отсутствуют</h3>
		<!-- Если заявки есть -->
		@else
			<!-- Цикл вывода записей -->
			@foreach($data->applications as $val)
				<div class="wrap">
					<h3 class="test-t-name">{{ $val->nickname }}</h3>
					<p class="test-t-status">Статус заявки: <b>{{ $val->status }}</b></p>
					<form action="{{ route('app_delete') }}" method="get">
						<input type="hidden" value="{{ $val->application_id }}" name="app_id">
						<p><input class="test-b-remove" type="submit" value="Удалить заявку"></p>
					</form>
				</div>
			@endforeach
		@endif
	</div>

	<br><div class="heading">Создать новую заявку</div>

	<!-- Форма создания новой заявки -->
	<form enctype="multipart/form-data" method="POST" action="{{ route('app_add') }}">
		<!-- Токен -->
		{{ csrf_field() }}

		<!-- Кличка домашнего любимца -->
		<p class="error">{{ $errors->app_add->first('nickname') }}</p>
		<p><input class="test-i-name" type="text" placeholder="Кличка домашнего любимца" name="nickname"></p>

		<!-- Изображение домашнего любимца -->
		<p class="error">{{ $errors->app_add->first('image') }}</p>
		<div class="left">
			<p>Изображение домашнего любимца:</p>
			<p><input class="test-c-photo" type="file" name="image"></p>
		</div>
		
		<!-- Кнопка отправки данных на сервер -->
		<p><input class="test-b-new" type="submit" value="Создать заявку"></p>
	</form>
@endsection