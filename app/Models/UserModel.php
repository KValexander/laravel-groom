<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
	// Таблица, первичный ключ
	protected $table = "users";
	protected $primaryKey = "id";

	// Функция получения всех заявок пользователя
	public function applications() {
		return $this->hasMany("App\Models\ApplicationModel", "user_id");
	}
}
