<!-- Подключение щаблона -->
@extends("shablon")

@section("content")
	<!-- Див с выводом сообщений в случае их наличия -->
	<div class="message">{{ $errors->message->first() }}</div>

	<div class="heading">Новые заявки</div>

	<div class="container">
		<!-- Если заявок нет -->
		@if(count($data->app_new) == 0)
			<h3>Заявки отсутствуют</h3>
		<!-- Если они есть -->
		@else
			<!-- Цикл вывода данных -->
			@foreach($data->app_new as $val)
				<div class="wrap">
					<a href="{{ asset($val->path_to_image) }}" target="blank"><img src="{{ asset($val->path_to_image) }}" alt=""></a>
					<h3 class="test-t-name">{{ $val->nickname }}</h3>
					<!-- Ссылка для обновление статуса заявки с "Новая" на "Обработка данных" -->
					<a href="{{ route('app_process', ['app_id' => $val->application_id]) }}" class="link">Сменить статус заявки на "Обработка данных"</a>
				</div>
			@endforeach
		@endif
	</div>


	<br><div class="heading">Обработка данных</div>

	<div class="container">
		<!-- Если заявок нет -->
		@if(count($data->app_process) == 0)
			<h3>Заявки отсутствуют</h3>
		<!-- Если они есть -->
		@else
			<!-- Цикл вывода данных -->
			@foreach($data->app_process as $val)
				<div class="wrap">
					<a href="{{ asset($val->path_to_image) }}" target="blank"><img src="{{ asset($val->path_to_image) }}" alt=""></a>
					<h3 class="test-t-name">{{ $val->nickname }}</h3>
					<!-- Форма для обновления статуса заявки с "Обработка данных" на "Услуга оказана" -->
					<form enctype="multipart/form-data" action="{{ route('app_access') }}" method="POST">
						{{ csrf_field() }}
						<input type="hidden" value="{{ $val->application_id }}" name="app_id">
						<p>Фотография оказанной услуги:</p>
						<p class="error">{{ $errors->app_access->first('image') }}</p>
						<p><input class="test-c-photo" type="file" name="image"></p>
						<p><input class="test-b-change" type="submit" value="Услуга оказана"></p>
					</form>
				</div>
			@endforeach
		@endif
	</div>


	<br><div class="heading">Оказанные услуги</div>

	<div class="container">
		<!-- Если заявок нет -->
		@if(count($data->app_access) == 0)
			<h3>Заявки отсутствуют</h3>
		<!-- Если они есть -->
		@else
			<!-- Цикл вывода данных -->
			@foreach($data->app_access as $val)
				<div class="wrap">
					<a href="{{ asset($val->path_to_image) }}" target="blank"><img src="{{ asset($val->path_to_image) }}" alt=""></a>
					<h3 class="test-t-name">{{ $val->nickname }}</h3>
				</div>
			@endforeach
		@endif
	</div>

@endsection