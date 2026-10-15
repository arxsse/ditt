<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model {
	protected $table = "ubdistrito";
	protected $primaryKey = "id";

	protected $fillable = [
		'idprovincia',
		'ubigeo',
		'descripcion',
	];

	public function provincia() {
		return $this->belongsTo(Provincia::class, 'idprovincia');
	}

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}
