<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\UserModel;
use App\Models\ApplicationModel;

class ModerationController extends Controller
{
	public function groom_page(Request $request) {
		$user = Auth::user();
		$app_new = ApplicationModel::where("status", "Новая")->orderBy("created_at", "DESC")->get();
		$app_process = ApplicationModel::where("status", "Обработка данных")->orderBy("created_at", "DESC")->get();
		$app_access = ApplicationModel::where("status", "Услуга оказана")->orderBy("created_at", "DESC")->get();

		$data = (object)[
			"user" => $user,
			"app_new" => $app_new,
			"app_process" => $app_process,
			"app_access" => $app_access,
		];

		return view("groom", ["data" => $data]);
	}

	public function app_process(Request $request) {
		$app_id = $request->input("app_id");
		$app = ApplicationModel::find($app_id);
		$app->status = "Обработка данных";
		$app->save();
		return redirect()->route("groom_page")->withErrors("Статус заявки изменён на \"Обработка данных\"", "message");
	}

	public function app_access(Request $request) {
		$app_id = $request->input("app_id");
		
		$messages = [
			"required" => "Поле :attribute обязательно для заполнения",
			"mimes" => "Изображение должно содержать расширения jpeg и bmp",
			"max" => "Изображение должно весить не более 2мб",
		];

		$validator = Validator::make($request->all(), [
			"image" => "required|mimes:jpeg,bmp|max:2048",
		], $messages);

		if($validator->fails()) {
			return redirect()->route("groom_page")->withErrors($validator, "app_access");
		}

		$image_name = "1_". rand() ."_". time() .".". $request->file("image")->extension();
		$request->file("image")->move(public_path("animals/after/"), $image_name);
		$path = "animals/after/". $image_name;

		$app = ApplicationModel::find($app_id);
		$app->path_to_image = $path;
		$app->status = "Услуга оказана";
		$app->save();

		return redirect()->route("groom_page")->withErrors("Статус заявки изменён на \"Услуга оказана\"", "message");
	}
}
