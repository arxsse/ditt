<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model {
	protected $table      = "pais";
	protected $primaryKey = "id";

	protected $fillable = [
		'codigo_iso character',
		'descripcion character',
		'continente character',
		'moneda character',
		'idioma_oficial',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}
