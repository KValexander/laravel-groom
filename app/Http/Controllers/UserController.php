<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Подключение моделей
use App\Models\UserModel;
use App\Models\ApplicationModel;

class UserController extends Controller
{
	// Функция вывода страницы личного кабинета пользовтеля
	public function user_page(Request $request) {
		// Получение данных авторизованного пользователя
		$user = Auth::user();
		// Получение всех заявок созданных пользователем
		$applications = UserModel::find($user->id)->applications()->orderBy("created_at", "DESC")->get();
		// Запись данных в объект
		$data = (object)[
			"user" => $user,
			"applications" => $applications
		];
		// Отправка данных представлению
		return view("user", ["data" => $data]);
	}

	// Функция добавления заявки
	public function app_add(Request $request) {
		// Сообщения валидации
		$messages = [
			"required" => "Поле :attribute обязательно для заполнения",
			"string" => "Поле :attribute должно быть строковым",
			"mimes" => "Изображение должно содержать расширения jpeg и bmp",
			"max" => "Изображение должно весить не более 2мб",
		];

		// Валидация
		$validator = Validator::make($request->all(), [
			"nickname" => "required|string",
			"image" => "required|mimes:jpeg,bmp|max:2048",
		], $messages);

		// Проверка на наличие ошибок валидации
		if($validator->fails()) {
			// Перенаправление на страницу личного кабинета с сообщениями об ошибках валидации
			return redirect()->route("user_page")->withErrors($validator, "app_add");
		}

		// Имя изображения
		$image_name = "1_". rand() ."_". time() .".". $request->file("image")->extension();
		// Перемещение изображения в папку public/animals/before/
		$request->file("image")->move(public_path("animals/before/"), $image_name);
		// Переменная с путём до изображения для поля базы данных
		$path = "animals/before/". $image_name;

		// Создание нового экземпляра модели
		$app = new ApplicationModel;
		// Добавление данных в экземпляр
		$app->user_id = Auth::id();
		$app->nickname = $request->input("nickname");
		$app->path_to_image = $path;
		$app->status = "Новая";
		// Сохранение экземпляра в базе данных
		$app->save();

		// Перенаправление на страницу личного кабинета с сообщением об успешном добавлении заявки
		return redirect()->route("user_page")->withErrors("Заявка добавлена", "message");
	}

	// Функция удаления заявки
	public function app_delete(Request $request) {
		// Получение id заявки
		$app_id = $request->input("app_id");
		// Получение нужной заявки по id
		$app = ApplicationModel::find($app_id);
		// Проверка, если другой пользователь хочет удалить заявку или статус заявки не равняется "Новая"
		if(Auth::id() != $app->user_id || $app->status != "Новая") {
			// Перенаправление на страницу личного кабинета с сообщением об ошибке
			return redirect()->route("user_page")->withErrors("В доступе отказано", "message");
		}
		// Удаление изображения в папке public
		unlink(public_path($app->path_to_image));
		// Удаление заявки
		$app->delete();
		// Перенаправление на страницу личного кабинет с сообщением об успешном удалении заявки
		return redirect()->route("user_page")->withErrors("Заявка удалена", "message");
	}
}
