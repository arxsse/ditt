<?php
namespace Database\Seeders\modulos;

use App\Models\seguridad\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class B90_PermisosSeeder extends Seeder {

	public function run($idempresa, $idrol) {
		$permisos = [

			// -------------------------------------------------------------------------------------------- Derecho autor
			//Tipo derecho autor
			'index-tipoderechoautor_' . $idempresa . '_' . $idrol,
			'create-tipoderechoautor_' . $idempresa . '_' . $idrol,
			'edit-tipoderechoautor_' . $idempresa . '_' . $idrol,
			'store-tipoderechoautor_' . $idempresa . '_' . $idrol,
			'destroy-tipoderechoautor_' . $idempresa . '_' . $idrol,
			'filtro-tipoderechoautor_' . $idempresa . '_' . $idrol,

			//Requisitos
			'index-requisito_' . $idempresa . '_' . $idrol,
			'create-requisito_' . $idempresa . '_' . $idrol,
			'edit-requisito_' . $idempresa . '_' . $idrol,
			'store-requisito_' . $idempresa . '_' . $idrol,
			'destroy-requisito_' . $idempresa . '_' . $idrol,
			'filtro-requisito_' . $idempresa . '_' . $idrol,

			//Solicitud
			'index-derechoautor_' . $idempresa . '_' . $idrol,
			'destroy-derechoautor_' . $idempresa . '_' . $idrol,
			'proceso-derechoautor_' . $idempresa . '_' . $idrol,
			'filtro-derechoautor_' . $idempresa . '_' . $idrol,

			// -------------------------------------------------------------------------------------------- Config
			//Empresa
			'index-empresa_' . $idempresa . '_' . $idrol,
			'create-empresa_' . $idempresa . '_' . $idrol,
			'edit-empresa_' . $idempresa . '_' . $idrol,
			'store-empresa_' . $idempresa . '_' . $idrol,
			'destroy-empresa_' . $idempresa . '_' . $idrol,
			'filtro-empresa_' . $idempresa . '_' . $idrol,

			//Tipo persona
			'index-tipopersona_' . $idempresa . '_' . $idrol,
			'create-tipopersona_' . $idempresa . '_' . $idrol,
			'edit-tipopersona_' . $idempresa . '_' . $idrol,
			'store-tipopersona_' . $idempresa . '_' . $idrol,
			'destroy-tipopersona_' . $idempresa . '_' . $idrol,
			'filtro-tipopersona_' . $idempresa . '_' . $idrol,

			//Tipo documento identidad
			'index-tipo_documento_identidad_' . $idempresa . '_' . $idrol,
			'create-tipo_documento_identidad_' . $idempresa . '_' . $idrol,
			'edit-tipo_documento_identidad_' . $idempresa . '_' . $idrol,
			'store-tipo_documento_identidad_' . $idempresa . '_' . $idrol,
			'destroy-tipo_documento_identidad_' . $idempresa . '_' . $idrol,
			'filtro-tipo_documento_identidad_' . $idempresa . '_' . $idrol,

			//Estado civil
			'index-estado_civil_' . $idempresa . '_' . $idrol,
			'create-estado_civil_' . $idempresa . '_' . $idrol,
			'edit-estado_civil_' . $idempresa . '_' . $idrol,
			'store-estado_civil_' . $idempresa . '_' . $idrol,
			'destroy-estado_civil_' . $idempresa . '_' . $idrol,
			'filtro-estado_civil_' . $idempresa . '_' . $idrol,

			//Sexo
			'index-sexo_' . $idempresa . '_' . $idrol,
			'create-sexo_' . $idempresa . '_' . $idrol,
			'edit-sexo_' . $idempresa . '_' . $idrol,
			'store-sexo_' . $idempresa . '_' . $idrol,
			'destroy-sexo_' . $idempresa . '_' . $idrol,
			'filtro-sexo_' . $idempresa . '_' . $idrol,

			//Persona
			'index-persona_' . $idempresa . '_' . $idrol,
			'create-persona_' . $idempresa . '_' . $idrol,
			'edit-persona_' . $idempresa . '_' . $idrol,
			'store-persona_' . $idempresa . '_' . $idrol,
			'destroy-persona_' . $idempresa . '_' . $idrol,
			'filtro-persona_' . $idempresa . '_' . $idrol,

			//Cargo
			'index-cargo_' . $idempresa . '_' . $idrol,
			'create-cargo_' . $idempresa . '_' . $idrol,
			'edit-cargo_' . $idempresa . '_' . $idrol,
			'store-cargo_' . $idempresa . '_' . $idrol,
			'destroy-cargo_' . $idempresa . '_' . $idrol,
			'filtro-cargo_' . $idempresa . '_' . $idrol,

			// -------------------------------------------------------------------------------------------- Seguridad
			//Boton
			'index-boton_' . $idempresa . '_' . $idrol,
			'create-boton_' . $idempresa . '_' . $idrol,
			'edit-boton_' . $idempresa . '_' . $idrol,
			'store-boton_' . $idempresa . '_' . $idrol,
			'destroy-boton_' . $idempresa . '_' . $idrol,
			'filtro-boton_' . $idempresa . '_' . $idrol,

			//modulo
			'index-modulo_' . $idempresa . '_' . $idrol,
			'create-modulo_' . $idempresa . '_' . $idrol,
			'edit-modulo_' . $idempresa . '_' . $idrol,
			'store-modulo_' . $idempresa . '_' . $idrol,
			'destroy-modulo_' . $idempresa . '_' . $idrol,
			'filtro-modulo_' . $idempresa . '_' . $idrol,

			//Rol
			'index-role_' . $idempresa . '_' . $idrol,
			'create-role_' . $idempresa . '_' . $idrol,
			'edit-role_' . $idempresa . '_' . $idrol,
			'store-role_' . $idempresa . '_' . $idrol,
			'destroy-role_' . $idempresa . '_' . $idrol,
			'filtro-role_' . $idempresa . '_' . $idrol,

			//Usuario
			'index-usuario_' . $idempresa . '_' . $idrol,
			'create-usuario_' . $idempresa . '_' . $idrol,
			'edit-usuario_' . $idempresa . '_' . $idrol,
			'store-usuario_' . $idempresa . '_' . $idrol,
			'destroy-usuario_' . $idempresa . '_' . $idrol,
			'reset-usuario_' . $idempresa . '_' . $idrol,
			'filtro-usuario_' . $idempresa . '_' . $idrol,

			//Accesos
			'index-accesos_' . $idempresa . '_' . $idrol,
			'store-accesos_' . $idempresa . '_' . $idrol,

		];

		foreach ($permisos as $permiso) {
			Permission::create(['name' => $permiso]);
		}

		$rol      = Role::find($idrol);
		$user     = User::find(1);
		$permisos = Permission::pluck('id', 'id')->all();
		$rol->syncPermissions($permisos);
		$user->assignRole($rol->id);
	}
}
