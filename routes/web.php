<?php

use Illuminate\Support\Facades\Route;

// Подключение контроллеров
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModerationController;

// Группа присваивания ролей
Route::group(["middleware" => "session"], function() {

	// Главная страница
	Route::get("/", [MainController::class, "main_page"])->name("main_page");
	// Регистраци
	Route::get("/register", [AuthController::class, "login"])->name("login");
	// Авторизация
	Route::get("/login", [AuthController::class, "register"])->name("register");

	// Группа только для авторизованных пользователей
	Route::group(["middleware" => "auth"], function() {

		// Страница личного кабинета
		Route::get("/user", [UserController::class, "user_page"])->name("user_page");
		// Добавление заявки
		Route::post("/user/app/add", [UserController::class, "app_add"])->name("app_add");
		// Удаление заявки
		Route::get("/user/app/delete", [UserController::class, "app_delete"])->name("app_delete");

		// Группа только для администраторов
		Route::group(["middleware" => "moderation"], function() {

			// Страница модерации
			Route::get("/groom", [ModerationController::class, "groom_page"])->name("groom_page");
			// Изменение статуса заявки на "Обработка данных"
			Route::get("/groom/app/process", [ModerationController::class, "app_process"])->name("app_process");
			// Изменение статуса заявки на "Услуга оказана"
			Route::post("/groom/app/access", [ModerationController::class, "app_access"])->name("app_access");

		});

		// Выход из авторизации
		Route::get("/logout", [AuthController::class, "logout"])->name("logout");
	});

});