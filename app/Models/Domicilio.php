<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domicilio extends Model {
	use SoftDeletes;

	protected $table      = "domicilio";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'descripcion',
		'abreviatura',
	];
}
