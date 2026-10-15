<?php
namespace Database\Seeders\modulos;

use App\Models\seguridad\Boton;
use Illuminate\Database\Seeder;

class B1_BotonSeeder extends Seeder {

	public function run($matriz) {

		foreach ($matriz["empresa"] as $key => $value):
			$botones = "";
			$botones .= "quitar_0,";

			// 1
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Crear';
			$data->funcion     = 'create';
			$data->clase       = 'btn btn-outline-primary me-1';
			$data->icono       = 'ti ti-apps-filled';
			$data->orden       = 4;
			$data->mostrar     = true;
			$data->es_boton    = true;
			$data->save();
			$botones .= $data->id . ",";

			// 2
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Editar';
			$data->funcion     = 'edit';
			$data->clase       = 'btn btn-outline text-primary me-1';
			$data->icono       = 'ti ti-edit';
			$data->orden       = 8;
			$data->mostrar     = true;
			$data->es_boton    = true;
			$data->save();
			$botones .= $data->id . ",";

			// 3
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Elim/Rest';
			$data->funcion     = 'destroy';
			$data->clase       = 'btn btn-outline text-danger';
			$data->icono       = 'fa-regular fa-trash-can mx-1';
			$data->orden       = 12;
			$data->mostrar     = true;
			$data->es_boton    = true;
			$data->save();
			$botones .= $data->id . ",";

			// 4
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Listar';
			$data->funcion     = 'index';
			$data->orden       = 0;
			$data->mostrar     = true;
			$data->save();
			$botones .= $data->id . ",";

			// 5
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Filtros';
			$data->funcion     = 'filtro';
			$data->clase       = 'text-primary';
			$data->icono       = 'ti ti-filter';
			$data->orden       = 0;
			$data->mostrar     = true;
			$data->save();
			$botones .= $data->id . ",";

			// 6
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Cambiar contraseña';
			$data->funcion     = 'reset';
			$data->clase       = 'btn btn-outline-dribbble me-2';
			$data->icono       = 'ti ti-lock-open';
			$data->orden       = 1;
			$data->mostrar     = true;
			$data->es_boton    = true;
			$data->save();
			$botones .= $data->id . ",";

			// 7
			$data              = new Boton();
			$data->idempresa   = $value["id"];
			$data->descripcion = 'Cambiar proceso';
			$data->funcion     = 'proceso';
			$data->clase       = 'btn btn-outline-primary me-2';
			$data->icono       = 'ti ti-replace';
			$data->orden       = 1;
			$data->mostrar     = true;
			$data->es_boton    = true;
			$data->save();
			$botones .= $data->id . ",";

			$botones                            = substr($botones, 0, -1);
			$matriz["empresa"][$key]["botones"] = $botones;

		endforeach;

		$this->call(B2_DerechoautorSeeder::class, false, compact('matriz'));
		$this->call(B4_ConfiguracionSeeder::class, false, compact('matriz'));
		$this->call(B80_SeguridadSeeder::class, false, compact('matriz'));

		foreach ($matriz["empresa"] as $key => $value) {
			$idempresa = $value["id"];
			$idrol     = $matriz["rol"];
			$this->call(B90_PermisosSeeder::class, false, compact('idempresa', 'idrol'));
		}
	}
}
