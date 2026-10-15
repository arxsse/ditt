<?php
namespace App\Models\derechoautor;

use App\Models\configuracion\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Derechoautor extends Model {
	use SoftDeletes;

	protected $casts = [
		'fecha' => 'datetime:d-m-Y',
		'hora'  => 'datetime',
	];

	protected $table      = "derechoautor.derechoautor";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		"idpais",
		"idempresa",
		'idtipoderechoautor',
		'idproceso',
		'nrocargo',
		'nroexpediente',
		'urlcodigofuente',
		'titulo',
		'fecha',
		'hora',
		'fecha_proceso',
		'hora_proceso',
		'urlresolucion',
		'observacion',
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

	public function tipoderechoautor() {
		return $this->belongsTo(Tipoderechoautor::class, 'idtipoderechoautor');
	}

	public function proceso() {
		return $this->belongsTo(Proceso::class, 'idproceso');
	}

	public function integranteprin() {
		return $this->hasOne(Derechoautor_integrante::class, 'idderechoautor')->where('principal', true);
	}

	public function integrantes() {
		return $this->hasMany(Derechoautor_integrante::class, 'idderechoautor')->OrderBy('principal', "DESC");
	}

	public function getFechaAttribute($value) {
		return $value ? Carbon::parse($value)->format('d-m-Y') : null;
	}

	public function getHoraAttribute($value) {
		return Carbon::parse($value)->format('h:i:s a');
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