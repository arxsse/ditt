<?php
namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller {
	public $modulo          = "rol";
	public $path_padre      = "seguridad";
	public $path_controller = "role";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Role();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "role";
		$datos["filtro"]          = $this->filtros([0, 2]);
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Role::withTrashed()->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		$objeto    = Role::select();

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
			->addColumn("estado", function ($objeto) {
				return (is_null($objeto->deleted_at)) ? '<span class="badge badge-dot bg-success"></span>' : '<span class="badge badge-dot bg-danger"></span>';
			})
			->rawColumns(["estado"])
			->make(true);
	}

	public function create() {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			"idempresa" => "required",
			'name'      => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "name", "idempresa")->ignore($request->id, "id")],
		], [
			"name.required" => "El campo nombre es obligatorio.",
			"name.unique"   => "El valor del campo nombre ya está en uso.",
		]);

		return DB::transaction(function () use ($request) {
			$obj = Role::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Role();
			endif;
			$obj->fill($request->all());
			$obj->save();
			return response()->json($obj);
		});

	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {

		if ($request->accion == "eliminar") {
			Role::find($request->id)->delete();
			return response()->json();
		}
		Role::withTrashed()->find($request->id)->restore();
		return response()->json();
	}

	public function get_role(Request $request) {
		$obj = Role::where("idempresa", $request->idempresa)->get();
		return response()->json($obj);
	}
}
