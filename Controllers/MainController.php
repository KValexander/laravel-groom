<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\UserModel;
use App\Models\ApplicationModel;

class MainController extends Controller
{
	public function main_page(Request $request) {
		$applications = ApplicationModel::where("status", "Услуга оказана")->orderBy("updated_at", "DESC")->limit(4)->get();
		$data = (object) [
			"applications" => $applications
		];
		return view("index", ["data" => $data]);
	}
}
