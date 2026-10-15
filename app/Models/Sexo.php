<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sexo extends Model {
	use SoftDeletes;

	protected $table = "sexo";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'descripcion',
		'abreviatura',
	];
}
