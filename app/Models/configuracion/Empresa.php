<?php
namespace App\Models\configuracion;

use App\Models\Distrito;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model {
	use SoftDeletes;

	protected $table      = "configuracion.empresa";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'idpais',
		'ruc',
		'razonsocial',
		'abreviatura',
		'oficina',
		'abreviatura_oficina',
		'ubigeo',
		'direccion',
		'celular',
		'rutaimagen',
		'sizeimagen',
		'decimal',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function distrito() {
		return $this->belongsTo(Distrito::class, 'ubigeo');
	}

	const PATH_FILE    = 'public/img/empresa/';
	protected $appends = ['path_file'];

	public function getPathFile() {
		return static::PATH_FILE;
	}

	public function getPathFileAttribute() {
		return url($this->getPathFile()) . '/';
	}
}
