<?php
namespace App\Http\Controllers\configuracion;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Cargo;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CargoController extends Controller {
	public $modulo          = "cargo";
	public $path_padre      = "configuracion";
	public $path_controller = "cargo";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Cargo();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "";
		$datos["filtro"]          = $this->filtros([0, 2]);
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Cargo::withTrashed()->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		$objeto    = Cargo::with("empresa");

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
			'idempresa'   => 'required',
			'codigo'      => 'required',
			'descripcion' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "descripcion")->ignore($request->id, "id")],
			'orden'       => ['required', 'numeric'],
		]);

		return DB::transaction(function () use ($request) {
			$obj = Cargo::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Cargo();
			endif;
			$obj->fill($request->all());
			$obj->save();
		});
	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {
		$obj = Cargo::withTrashed()->find($request->id);
		if ($request->accion == "eliminar"):
			$obj->delete();
			return response()->json();
		endif;
		$obj->restore();
		return response()->json();
	}

	public function get_cargo(Request $request) {
		$obj = Cargo::where("idempresa", $request->idempresa)->orderBy("descripcion")->get();
		return response()->json($obj);
	}

}
