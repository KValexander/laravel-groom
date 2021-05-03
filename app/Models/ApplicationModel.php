<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationModel extends Model
{
	// Таблица, первичный ключ
	protected $table = "application";
	protected $primaryKey = "application_id";
}
