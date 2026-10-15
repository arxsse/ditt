<?php
namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Boton;
use App\Models\seguridad\Boton_modulo;
use App\Models\seguridad\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class ModuloController extends Controller {
	public $modulo          = "módulo";
	public $path_padre      = "seguridad";
	public $path_controller = "modulo";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Modulo();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "modulo";
		$datos["filtro"]          = $this->filtros([0, 2]);
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);

		$datos["data"]       = [];
		$datos["data_boton"] = [];
		if ($id != null):
			$datos["data"]       = Modulo::withTrashed()->find($id);
			$datos["padre"]      = Modulo::where("id", "!=", $id)->get();
			$datos["data_boton"] = Boton_modulo::with('boton')->where("idmodulo", $id)->get();
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		$objeto    = Modulo::with('padre');

		// Filtro empresa
		if ($idempresa != null):
			$objeto->where("idempresa", $idempresa);
		elseif ($request->empresa != -1):
			$objeto->where("idempresa", $request->empresa);
		endif;

		// Filtro estado
		if ($request->estado != 1):
			eval('$objeto->' . $request->estado);
		endif;

		return DataTables::of($objeto)
			->addIndexColumn()
			->addColumn("icono", function ($objeto) {
				return "<i class='{$objeto->icono}'></i>";
			})
			->addColumn("estado", function ($objeto) {
				return (is_null($objeto->deleted_at)) ? '<span class="badge badge-dot bg-success"></span>' : '<span class="badge badge-dot bg-danger"></span>';
			})
			->rawColumns(['icono', "estado"])
			->make(true);
	}

	public function create() {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			"idempresa"   => "required",
			"descripcion" => "required",
			"orden"       => "required|integer",
			"url"         => "required",
		]);

		return DB::transaction(function () use ($request) {
			$obj = Modulo::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Modulo();
			endif;
			$obj->fill($request->all());
			$obj->accesos_directo = (isset($request->accesos_directo)) ? true : false;
			if ($obj->save()) {
				if ($request->filled("boton")):
					foreach ($request->input("boton") as $key => $value):
						if ($key == 0):
							Boton_modulo::where("idmodulo", $obj->id)->delete();
						endif;

						$obj2 = Boton_modulo::where("idmodulo", $obj->id)->where('idboton', $value["idboton"])->withTrashed()->first();
						if (is_null($obj2)):
							$obj2 = new Boton_modulo();
						endif;

						$obj2->idmodulo   = $obj->id;
						$obj2->idboton    = $value["idboton"];
						$obj2->deleted_at = null;
						$obj2->save();
					endforeach;
				else:
					Boton_modulo::where("idmodulo", $obj->id)->delete();
				endif;

				if ($request->id != null) {
					$compro = Boton_modulo::with("boton")->where("idmodulo", $obj->id)->whereNotNull("deleted_at")->withTrashed()->get();
					foreach ($compro as $key => $value) {
						$name      = $value["boton"]["funcion"] . "-" . $obj->url . "_" . $obj->idempresa;
						$verificar = Permission::join('seguridad.role_permisos as r_p', 'seguridad.permisos.id', '=', 'r_p.permission_id')->where("name", "like", "%" . $name . "%")->count();
						if ($verificar >= 1) {
							throw ValidationException::withMessages(['required_accesos' => $value["id"]]);
						}

					}
				}

			}
			return response()->json($obj);
		});

	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {

		if ($request->accion == "eliminar") {
			Modulo::find($request->id)->delete();
			return response()->json();
		}
		Modulo::withTrashed()->find($request->id)->restore();
		return response()->json();
	}

	public function get_modulopadre(Request $request) {
		$obj = Modulo::where("idempresa", $request->idempresa)->whereNull("idpadre")->orderBy("orden")->get();
		return response()->json($obj);
	}

	public function get_padre(Request $request) {
		$obj = Modulo::where("idempresa", $request->idempresa)->orderBy("orden")->get();
		return response()->json($obj);
	}

}