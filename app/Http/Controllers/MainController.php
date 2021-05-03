<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Подключение моделей
use App\Models\UserModel;
use App\Models\ApplicationModel;

class MainController extends Controller
{
	// Функция вывода данных на главную страницу
	public function main_page(Request $request) {
		// Запрос на получение 4 последних записей со статусом "Услуга оказана"
		$applications = ApplicationModel::where("status", "Услуга оказана")->orderBy("updated_at", "DESC")->limit(4)->get();
		// Запись заявок в объект
		$data = (object) [
			"applications" => $applications
		];
		// Отправка объекта представлению
		return view("index", ["data" => $data]);
	}
}
