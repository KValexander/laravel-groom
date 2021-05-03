<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Подключение моделей
use App\Models\UserModel;
use App\Models\ApplicationModel;

class ModerationController extends Controller
{
	// Функция вывода страницу модерации
	public function groom_page(Request $request) {
		// Получение данных авторизованного пользователя
		$user = Auth::user();
		// Запрос на получение заявок со статусом "Новая"
		$app_new = ApplicationModel::where("status", "Новая")->orderBy("created_at", "DESC")->get();
		// Запрос на получение заявок со статусом "Обработка данных"
		$app_process = ApplicationModel::where("status", "Обработка данных")->orderBy("created_at", "DESC")->get();
		// Запрос на получение заявок со статусом "Услуга оказана"
		$app_access = ApplicationModel::where("status", "Услуга оказана")->orderBy("created_at", "DESC")->get();

		// Запись данных в объект
		$data = (object)[
			"user" => $user,
			"app_new" => $app_new,
			"app_process" => $app_process,
			"app_access" => $app_access,
		];

		// Отправка объекта представлению
		return view("groom", ["data" => $data]);
	}

	// Функция изменения статуса заявки на "Обработка данных"
	public function app_process(Request $request) {
		// Получение id заявки
		$app_id = $request->input("app_id");
		// Получение нужной заявки по id
		$app = ApplicationModel::find($app_id);
		// Измениение статуса
		$app->status = "Обработка данных";
		// Сохранение изменений
		$app->save();
		// Перенаправление на страницу модерации с сообщением об успешном изменении статуса
		return redirect()->route("groom_page")->withErrors("Статус заявки изменён на \"Обработка данных\"", "message");
	}

	// Функция изменения статуса заявки на "Услуга оказана"
	public function app_access(Request $request) {
		// Получение id заявки
		$app_id = $request->input("app_id");
		
		// Сообщение валидации
		$messages = [
			"required" => "Поле :attribute обязательно для заполнения",
			"mimes" => "Изображение должно содержать расширения jpeg и bmp",
			"max" => "Изображение должно весить не более 2мб",
		];

		// Валидация
		$validator = Validator::make($request->all(), [
			"image" => "required|mimes:jpeg,bmp|max:2048",
		], $messages);

		// Проверка на наличие ошибок валидации
		if($validator->fails()) {
			// Перенаправление на страницу модерации с сообщениями об ошибках валидации
			return redirect()->route("groom_page")->withErrors($validator, "app_access");
		}

		// Имя изображения
		$image_name = "1_". rand() ."_". time() .".". $request->file("image")->extension();
		// Перемещение изображения в папку public/animals/after/
		$request->file("image")->move(public_path("animals/after/"), $image_name);
		// Переменная с путём до изображения для поля базы данных
		$path = "animals/after/". $image_name;

		// Получение нужной заявки по id
		$app = ApplicationModel::find($app_id);
		// Изменение данных записи
		$app->path_to_image = $path;
		$app->status = "Услуга оказана";
		// Сохранение изменений записи
		$app->save();

		// Перенаправление на страницу модерации с сообщением об успешном изменении статуса
		return redirect()->route("groom_page")->withErrors("Статус заявки изменён на \"Услуга оказана\"", "message");
	}
}
