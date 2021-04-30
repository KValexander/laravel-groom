<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\UserModel;
use App\Models\ApplicationModel;

class AuthController extends Controller
{
	public function register(Request $request) {

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

		$validator = Validator::make($request->all(), [
			"fio" => "required|string|regex:/^[а-яА-ЯёЁ]/u",
			"login" => "required|string|unique:users,login|regex:/^[a-zA-Z\-]/",
			"email" => "required|string|email",
			"password" => "required|required_with:password_pass|same:password_pass",
			"password_pass" => "required",
			"privacy" => "accepted",
		], $messages);

		if($validator->fails()) {
			return redirect()->route("main_page")->withErrors($validator, "register");
		}

		$user = new UserModel;
		$user->fio = $request->input("fio");
		$user->login = $request->input("login");
		$user->email = $request->input("email");
		$user->password = bcrypt($request->input("password"));
		$user->role = "user";
		$user->save();

		return redirect()->route("main_page")->withErrors("Вы зарегистрировались", "message");
	}

	public function login(Request $request) {
		$login = $request->input("login");
		$password = $request->input("password");

		if(Auth::attempt(["login" => $login, "password" => $password], true)) {
			return redirect()->route("user_page");
		} else {
			return redirect()->route("main_page")->withErrors("Ошибка логина или пароля", "login");
		}
	}

	public function logout(Request $request) {
		Auth::logout();
		return redirect()->route("main_page");
	}
}
