<?php
namespace App\Models\derechoautor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipoderechoautor_requisitos extends Model {
	use SoftDeletes;

	protected $table      = "derechoautor.tipoderechoautor_requisitos";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'idtipoderechoautor',
		'descripcion',
		'urlejemplo',
		'seenvia',
		'orden',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function tipoderechoautor() {
		return $this->belongsTo(Tipoderechoautor::class, 'idtipoderechoautor');
	}
}
