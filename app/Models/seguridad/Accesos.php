<?php
namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accesos extends Model {
	use SoftDeletes;

	protected $table = "seguridad.accesos";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'idempresa',
		'idmodulo',
		'idrole',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}
