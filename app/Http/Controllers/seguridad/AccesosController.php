<?php
namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Accesos;
use App\Models\seguridad\Boton;
use App\Models\seguridad\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AccesosController extends Controller {
	public $modulo          = "accesos";
	public $path_padre      = "seguridad";
	public $path_controller = "accesos";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Accesos();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "accesos";
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function acceso(Request $request) {
		return response()->json((new Modulo)->acceso_modulos($request->idempresa, $request->idpadre, $request->idrole));
	}

	public function store(Request $request) {
		$this->validate($request, [
			"idempresa" => "required",
			"idpadre"   => "required",
			"idrole"    => "required",
		]);

		return DB::transaction(function () use ($request) {
			$idempresa        = $request->idempresa;
			$idrole           = $request->idrole;
			$array_mdpermisos = [];
			$array_funcion    = [];

			foreach (Modulo::where("idempresa", $idempresa)->get() as $modulos):
				foreach (Boton::get() as $key => $value):
					$validar = Permission::where("name", $value["funcion"] . "-" . $modulos["url"] . "_" . $idempresa . "_" . $idrole)
						->join("seguridad.role_permisos as r_p", "r_p.permission_id", "id")
						->where("r_p.role_id", $idrole)
						->count();

					if ($validar == 1):
						$array_mdpermisos[$modulos["id"]][$value["funcion"]] = ["funcion" => $value["funcion"] . "-" . $modulos["url"] . "_" . $idempresa . "_" . $idrole];
					endif;
				endforeach;
			endforeach;

			if ($request->filled("accesos_true") OR $request->filled("accesos_false")):
				if ($request->filled("accesos_false")):
					foreach ($request->accesos_false as $key => $value):
						$ids      = explode("-", $value["id"]);
						$idmodulo = $ids[1];
						$funcion  = $ids[2];
						$idpadre  = $ids[3];

						if ($idpadre != ""):
							Accesos::where("idempresa", $idempresa)->where("idmodulo", $idpadre)->where("idrole", $idrole)->delete();
						endif;

						Accesos::where("idempresa", $idempresa)->where("idmodulo", $idmodulo)->where("idrole", $idrole)->delete();
						if (array_key_exists($idmodulo, $array_mdpermisos)):
							unset($array_mdpermisos[$idmodulo][$funcion]);
						endif;
					endforeach;
				endif;

				if ($request->filled("accesos_true")):
					foreach ($request->accesos_true as $key => $value):
						$ids      = explode("-", $value["id"]);
						$idmodulo = $ids[1];
						$funcion  = $ids[2];
						$idpadre  = $ids[3];

						if ($idpadre != ""):
							$obj = Accesos::where("idempresa", $idempresa)->where('idmodulo', $idpadre)->where("idrole", $idrole)->withTrashed()->first();
							if (is_null($obj)):
								$obj = new Accesos();
							endif;
							$obj->idempresa  = $idempresa;
							$obj->idmodulo   = $idpadre;
							$obj->idrole     = $idrole;
							$obj->deleted_at = null;
							$obj->save();
						endif;

						$obj = Accesos::where("idempresa", $idempresa)->where('idmodulo', $idmodulo)->where("idrole", $idrole)->withTrashed()->first();
						if (is_null($obj)):
							$obj = new Accesos();
						endif;
						$obj->idempresa  = $idempresa;
						$obj->idmodulo   = $idmodulo;
						$obj->idrole     = $idrole;
						$obj->deleted_at = null;
						if ($obj->save()):
							$modulo = Modulo::find($idmodulo);
							if ($funcion == "create" OR $funcion == "edit"):
								$array_mdpermisos[$idmodulo]["store"] = ["funcion" => "store-" . $modulo["url"] . "_" . $idempresa . "_" . $idrole];
							endif;
							$array_mdpermisos[$idmodulo][$funcion] = ["funcion" => $funcion . "-" . $modulo["url"] . "_" . $idempresa . "_" . $idrole];
						endif;
					endforeach;
				endif;

				if (count($array_mdpermisos) > 0):
					foreach ($array_mdpermisos as $key => $value):
						foreach ($value as $funcion):
							if (Permission::where("name", $funcion["funcion"])->count() == 0):
								Permission::create(["name" => $funcion["funcion"]]);
							endif;
							array_push($array_funcion, $funcion["funcion"]);
						endforeach;
					endforeach;
					$role = Role::find($idrole);
					$role->syncPermissions($array_funcion);
				endif;
				return response()->json($request);

			else:
				throw ValidationException::withMessages(["accesos' => 'Lista de accesos vacia."]);
			endif;
		});
	}
}
