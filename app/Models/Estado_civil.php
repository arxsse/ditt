<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado_civil extends Model {
	use SoftDeletes;

	protected $table = "estado_civil";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'descripcion',
		'abreviatura',
	];
}
