<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipopersona extends Model {
	use SoftDeletes;

	protected $table = "tipopersona";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'descripcion',
		'codigo',
	];
}
