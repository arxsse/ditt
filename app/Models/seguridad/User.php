<?php
namespace App\Models\seguridad;

use App\Models\configuracion\Sucursal;
use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

	protected $table      = "seguridad.usuario";
	protected $primaryKey = "id";

	protected $fillable = [
		'deleted_at',
		'idpersona',
		'idrole',
		'idsucursal',
		'usuario',
		'password',
	];

	protected $hidden = [
		'password', 'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
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

	public function role() {
		return $this->belongsTo(Role::class, 'idrole');
	}

	public function sucursal() {
		return $this->belongsTo(Sucursal::class, 'idsucursal');
	}
}
