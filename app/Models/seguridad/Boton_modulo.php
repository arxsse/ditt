<?php
namespace App\Models\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boton_modulo extends Model {
	use SoftDeletes;

	protected $table = "seguridad.boton_modulo";
	protected $primaryKey = "id";

	protected $fillable = [
		"deleted_at",
		"idmodulo",
		"idboton",
	];

	public function boton() {
		return $this->belongsTo(Boton::class, 'idboton');
	}

}
