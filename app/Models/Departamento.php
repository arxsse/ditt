<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model {
	protected $table = "ubdepartamento";
	protected $primaryKey = "id";

	protected $fillable = [
		'ubigeo',
		'descripcion',
	];

	public function provincia() {
		return $this->hasMany(Provincia::class, 'iddepartamento');
	}

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}
