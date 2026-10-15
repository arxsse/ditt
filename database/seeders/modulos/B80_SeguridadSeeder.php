<?php
namespace Database\Seeders\modulos;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\Boton_modulo;
use App\Models\seguridad\Modulo;
use Illuminate\Database\Seeder;

class B80_SeguridadSeeder extends Seeder {

	public function run($matriz) {

		$idrol = $matriz["rol"];
		foreach ($matriz["empresa"] as $key => $value):
			$idempresa = $value["id"];
			$botones   = explode(',', $value["botones"]);

			//------------------------- Padre
			$modp              = new Modulo();
			$modp->idempresa   = $idempresa;
			$modp->descripcion = "Seguridad";
			$modp->abreviatura = "Seg.";
			$modp->url         = "#";
			$modp->icono       = "ti ti-lock";
			$modp->orden       = 10;
			$modp->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $modp->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp->id;
			$mod->descripcion = "Botón";
			$mod->abreviatura = "Bot.";
			$mod->url         = "boton";
			$mod->icono       = null;
			$mod->orden       = 2;
			$mod->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $mod->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo_boton
			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[1];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[2];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[3];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[4];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[5];
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp->id;
			$mod->descripcion = "Módulo";
			$mod->abreviatura = "Mod.";
			$mod->url         = "modulo";
			$mod->icono       = null;
			$mod->orden       = 3;
			$mod->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $mod->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo_boton
			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[1];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[2];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[3];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[4];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[5];
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp->id;
			$mod->descripcion = "Rol";
			$mod->abreviatura = "Rol.";
			$mod->url         = "role";
			$mod->icono       = null;
			$mod->orden       = 4;
			$mod->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $mod->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo_boton
			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[1];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[2];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[3];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[4];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[5];
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp->id;
			$mod->descripcion = "Usuario";
			$mod->abreviatura = "Usu.";
			$mod->url         = "usuario";
			$mod->icono       = null;
			$mod->orden       = 5;
			$mod->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $mod->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo_boton
			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[1];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[2];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[3];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[4];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[5];
			$data->save();

			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[6];
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp->id;
			$mod->descripcion = "Accesos";
			$mod->abreviatura = "Acc.";
			$mod->url         = "accesos";
			$mod->icono       = null;
			$mod->orden       = 6;
			$mod->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $mod->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo_boton
			$data           = new Boton_modulo();
			$data->idmodulo = $mod->id;
			$data->idboton  = $botones[4];
			$data->save();

		endforeach;
	}
}