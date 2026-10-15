<?php
namespace Database\Seeders\modulos;

use App\Models\seguridad\Accesos;
use App\Models\seguridad\Boton_modulo;
use App\Models\seguridad\Modulo;
use Illuminate\Database\Seeder;

class B4_ConfiguracionSeeder extends Seeder {

	public function run($matriz) {

		$idrol = $matriz["rol"];
		foreach ($matriz["empresa"] as $key => $value):
			$idempresa = $value["id"];
			$botones   = explode(',', $value["botones"]);

			//------------------------- Padre
			$modp              = new Modulo();
			$modp->idempresa   = $idempresa;
			$modp->descripcion = "Configuración";
			$modp->abreviatura = "Conf.";
			$modp->url         = "#";
			$modp->icono       = "ti ti-settings-cog";
			$modp->orden       = 3;
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
			$mod->descripcion = "Empresa";
			$mod->abreviatura = "Emp.";
			$mod->url         = "empresa";
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

//----------------------------------------------------------------------------------------------------->> START Personal
			//------------------------- Padre
			$modp1              = new Modulo();
			$modp1->idempresa   = $idempresa;
			$modp1->idpadre     = $modp->id;
			$modp1->descripcion = "Personal";
			$modp1->abreviatura = "Per.";
			$modp1->url         = "#";
			$modp1->orden       = 3;
			$modp1->save();

			//------------------------- Accesos
			$data            = new Accesos();
			$data->idempresa = $idempresa;
			$data->idmodulo  = $modp1->id;
			$data->idrole    = $idrol;
			$data->save();

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp1->id;
			$mod->descripcion = "Tipo persona";
			$mod->abreviatura = "Tip. Per.";
			$mod->url         = "tipopersona";
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
			$mod->idpadre     = $modp1->id;
			$mod->descripcion = "Tipo documento";
			$mod->abreviatura = "Tip. Doc.";
			$mod->url         = "tipo_documento_identidad";
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
			$mod->idpadre     = $modp1->id;
			$mod->descripcion = "Estado civil";
			$mod->abreviatura = "Est. Civ.";
			$mod->url         = "estado_civil";
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
			$mod->idpadre     = $modp1->id;
			$mod->descripcion = "Sexo";
			$mod->abreviatura = "Sex.";
			$mod->url         = "sexo";
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

			//------------------------- Modulo
			$mod              = new Modulo();
			$mod->idempresa   = $idempresa;
			$mod->idpadre     = $modp1->id;
			$mod->descripcion = "Persona";
			$mod->abreviatura = "Per.";
			$mod->url         = "persona";
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

//----------------------------------------------------------------------------------------------------->> END Personal
		endforeach;
	}
}