<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\UserModel;
use App\Models\ApplicationModel;

class UserController extends Controller
{
	public function user_page(Request $request) {
		$user = Auth::user();
		$applications = UserModel::find($user->id)->applications()->orderBy("created_at", "DESC")->get();
		$data = (object)[
			"user" => $user,
			"applications" => $applications
		];
		return view("user", ["data" => $data]);
	}

	public function app_add(Request $request) {
		$messages = [
			"required" => "Поле :attribute обязательно для заполнения",
			"string" => "Поле :attribute должно быть строковым",
			"mimes" => "Изображение должно содержать расширения jpeg и bmp",
			"max" => "Изображение должно весить не более 2мб",
		];

		$validator = Validator::make($request->all(), [
			"nickname" => "required|string",
			"image" => "required|mimes:jpeg,bmp|max:2048",
		], $messages);

		if($validator->fails()) {
			return redirect()->route("user_page")->withErrors($validator, "app_add");
		}

		$image_name = "1_". rand() ."_". time() .".". $request->file("image")->extension();
		$request->file("image")->move(public_path("animals/before/"), $image_name);
		$path = "animals/before/". $image_name;

		$app = new ApplicationModel;
		$app->user_id = Auth::id();
		$app->nickname = $request->input("nickname");
		$app->path_to_image = $path;
		$app->status = "Новая";
		$app->save();

		return redirect()->route("user_page")->withErrors("Заявка добавлена", "message");
	}

	public function app_delete(Request $request) {
		$app_id = $request->input("app_id");
		$app = ApplicationModel::find($app_id);
		if(Auth::id() != $app->user_id || $app->status != "Новая") {
			return redirect()->route("user_page")->withErrors("В доступе отказано", "message");
		}
		unlink(public_path($app->path_to_image));
		$app->delete();
		return redirect()->route("user_page")->withErrors("Заявка удалена", "message");
	}
}
