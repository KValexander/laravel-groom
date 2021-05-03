<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Подключение моделей
use App\Models\UserModel;
use App\Models\ApplicationModel;

class AuthController extends Controller
{
	// Функция регистрации пользователя
	public function register(Request $request) {

		// Сообщение валидации
		$messages = [
			"required" => "Поле :attribute обязательно для заполнения",
			"string" => "Поле :attribute должно быть строковым",
			"regex" => "Поле :attribute должно соответствовать указанным правилам",
			"unique" => "Поле :attribute уникально и неповторяемо",
			"email" => "Поле :attribute должно соответствовать email формату (наличие @)",
			"required_with" => "Пароли не совпадают",
			"same" => "Пароли не совпадают",
			"accepted" => "Обязательное согласие",
		];

		// Валидация
		$validator = Validator::make($request->all(), [
			"fio" => "required|string|regex:/^[а-яА-ЯёЁ]/u",
			"login" => "required|string|unique:users,login|regex:/^[a-zA-Z\-]/",
			"email" => "required|string|email",
			"password" => "required|required_with:password_pass|same:password_pass",
			"password_pass" => "required",
			"privacy" => "accepted",
		], $messages);

		// Проверка на наличие ошибок валидации
		if($validator->fails()) {
			// Перенаправление на главную страницу с сообщениями об ошибках валидации
			return redirect()->route("main_page")->withErrors($validator, "register");
		}

		// Создание нового экземпляра модели
		$user = new UserModel;
		// Добавление данных в экземпляр
		$user->fio = $request->input("fio");
		$user->login = $request->input("login");
		$user->email = $request->input("email");
		$user->password = bcrypt($request->input("password"));
		$user->role = "user";
		// Сохранение экземпляра в базе данных
		$user->save();

		// Перенаправление на главную страницу с сообщением об успешной регистрации
		return redirect()->route("main_page")->withErrors("Вы зарегистрировались", "message");
	}

	// Функция авторизации пользователя
	public function login(Request $request) {
		// Запись полученных данных в переменные
		$login = $request->input("login");
		$password = $request->input("password");

		// Проверка авторизации
		if(Auth::attempt(["login" => $login, "password" => $password], true)) {
			// Перенаправление на страницу личного кабинета
			return redirect()->route("user_page");
		// В случае неудачи
		} else {
		// Перенаправление на главную страницу с сообщением об ошибке авторизации
			return redirect()->route("main_page")->withErrors("Ошибка логина или пароля", "login");
		}
	}

	// Функция выхода из аккаунта
	public function logout(Request $request) {
		// Выход из аккаунта
		Auth::logout();
		// Перенаправление на главную страницу
		return redirect()->route("main_page");
	}
}
