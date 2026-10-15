<?php
namespace Database\Seeders\modulos;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\Boton_modulo;
use App\Models\seguridad\Modulo;
use Illuminate\Database\Seeder;

class B2_DerechoautorSeeder extends Seeder {

	public function run($matriz) {

		$idrol = $matriz["rol"];
		foreach ($matriz["empresa"] as $key => $value):
			$idempresa = $value["id"];
			$botones   = explode(',', $value["botones"]);

			//------------------------- Padre
			$modp              = new Modulo();
			$modp->idempresa   = $idempresa;
			$modp->descripcion = "Propiedad intelectual";
			$modp->abreviatura = "Pro. Int.";
			$modp->url         = "#";
			$modp->icono       = "ti ti-certificate";
			$modp->orden       = 1;
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
			$mod->descripcion = "Tipo";
			$mod->abreviatura = "Tip.";
			$mod->url         = "tipoderechoautor";
			$mod->icono       = null;
			$mod->orden       = 1;
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
			$mod->descripcion = "Requisito";
			$mod->abreviatura = "Req.";
			$mod->url         = "requisito";
			$mod->icono       = null;
			$mod->orden       = 1;
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
			$mod->descripcion = "Solicitud";
			$mod->abreviatura = "Sol.";
			$mod->url         = "derechoautor";
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
			$data->idboton  = $botones[7];
			$data->save();

//----------------------------------------------------------------------------------------------------->> END Personal
		endforeach;
	}
}