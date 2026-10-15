<?php
namespace App\Models\derechoautor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Derechoautor_requisito extends Model {
	use SoftDeletes;

	protected $table      = "derechoautor.derechoautor_requisito";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'idderechoautor',
		'descripcion',
		'rutadocumento',
		'sizedocumento',
		'orden',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	const PATH_FILE    = 'public/doc/derechoautor/requisitos/';
	protected $appends = ['path_file'];

	public function getPathFile() {
		return static::PATH_FILE;
	}

	public function getPathFileAttribute() {
		return url($this->getPathFile()) . '/';
	}

}
