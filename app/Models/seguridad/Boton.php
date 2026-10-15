<?php
namespace App\Models\seguridad;

use App\Models\configuracion\Empresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boton extends Model {
	use SoftDeletes;

	protected $table      = "seguridad.boton";
	protected $primaryKey = "id";

	protected $fillable = [
		"deleted_at",
		"idempresa",
		"descripcion",
		"funcion",
		"clase",
		"icono",
		"orden",
		"mostrar",
		"es_boton",
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function empresa() {
		return $this->belongsTo(Empresa::class, 'idempresa');
	}
}
