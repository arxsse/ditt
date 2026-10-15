<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {
	protected $table = "ubprovincia";
	protected $primaryKey = "id";

	protected $fillable = [
		'iddepartamento',
		'ubigeo',
		'descripcion',
	];

	public function departamento() {
		return $this->belongsTo(Departamento::class, 'iddepartamento');
	}

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}
