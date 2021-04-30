<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
	protected $table = "users";
	protected $primaryKey = "id";

	public function applications() {
		return $this->hasMany("App\Models\ApplicationModel", "user_id");
	}
}
