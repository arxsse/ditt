<?php
namespace App\Models;

use App\Models\configuracion\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model {
	use SoftDeletes;

	protected $casts = [
		'fecha_nacimiento' => 'datetime:d-m-Y',
	];

	protected $table      = "persona";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		"idpais",
		"idempresa",
		"idfacultad",
		"idoficina",
		'idtipopersona',
		'idtipo_documento_identidad',
		'numero_documento_identidad',
		'ubigeo_procedencia',
		'ubigeo_actual',
		'idsexo',
		'idestado_civil',
		'nombres',
		'apellido_paterno',
		'apellido_materno',
		'nombre_completo',
		'rutaimagen',
		'sizeimagen',
		'correo',
		'tipocalle',
		'direccion',
		'celular',
		'fecha_nacimiento',
		'representante',
	];

	public function getTableName() {
		return (explode(".", $this->table))[1];
	}

	public function getSchemaName() {
		return (explode(".", $this->table))[0] ?? "public";
	}

	public function pais() {
		return $this->belongsTo(Pais::class, 'idpais');
	}

	public function empresa() {
		return $this->belongsTo(Empresa::class, 'idempresa');
	}

	public function tipo_documento_identidad() {
		return $this->belongsTo(Tipo_documento_identidad::class, 'idtipo_documento_identidad');
	}

	public function distrito_procedencia() {
		return $this->belongsTo(Distrito::class, 'ubigeo_procedencia');
	}

	public function distrito_actual() {
		return $this->belongsTo(Distrito::class, 'ubigeo_actual');
	}

	public function sexo() {
		return $this->belongsTo(Sexo::class, 'idsexo');
	}

	public function estado_civil() {
		return $this->belongsTo(Estado_civil::class, 'idestado_civil');
	}

	public function getFechaNacimientoAttribute($value) {
		return $value ? Carbon::parse($value)->format('d-m-Y') : null;
	}

	const PATH_FILE    = 'public/img/persona/';
	protected $appends = ['path_file'];
	public function getPathFile() {
		return static::PATH_FILE;
	}

	public function getPathFileAttribute() {
		return url($this->getPathFile()) . '/';
	}
}
