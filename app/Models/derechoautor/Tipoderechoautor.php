<?php
namespace App\Models\derechoautor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipoderechoautor extends Model {
	use SoftDeletes;

	protected $table      = "derechoautor.tipoderechoautor";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		"idpais",
		"idempresa",
		'categoria',
		'icono',
		'descripcion',
		'resumen',
		'orden',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function requisitosform() {
		return $this->hasMany(Tipoderechoautor_requisitos::class, 'idtipoderechoautor')
			->select("id", "idtipoderechoautor", "descripcion", "urlejemplo", "orden")->where("seenvia", true);
	}
}
