<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModerationController;

Route::group(["middleware" => "session"], function() {

	Route::get("/", [MainController::class, "main_page"])->name("main_page");
	Route::get("/register", [AuthController::class, "login"])->name("login");
	Route::get("/login", [AuthController::class, "register"])->name("register");

	Route::group(["middleware" => "auth"], function() {

		Route::get("/user", [UserController::class, "user_page"])->name("user_page");
		Route::post("/user/app/add", [UserController::class, "app_add"])->name("app_add");
		Route::get("/user/app/delete", [UserController::class, "app_delete"])->name("app_delete");

		Route::group(["middleware" => "moderation"], function() {

			Route::get("/groom", [ModerationController::class, "groom_page"])->name("groom_page");
			Route::get("/groom/app/process", [ModerationController::class, "app_process"])->name("app_process");
			Route::post("/groom/app/access", [ModerationController::class, "app_access"])->name("app_access");

		});

		Route::get("/logout", [AuthController::class, "logout"])->name("logout");
	});

});