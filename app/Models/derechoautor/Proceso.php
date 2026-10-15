<?php
namespace App\Models\derechoautor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model {
	use SoftDeletes;

	protected $table      = "derechoautor.proceso";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'descripcion',
		'clase',
		'orden',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}
}