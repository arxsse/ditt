<?php
namespace App\Models\derechoautor;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Derechoautor_integrante extends Model {
	use SoftDeletes;

	protected $table      = "derechoautor.derechoautor_integrante";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'principal',
		'idderechoautor',
		'idpersona',
		'orden',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function persona() {
		return $this->belongsTo(Persona::class, 'idpersona');
	}
}
