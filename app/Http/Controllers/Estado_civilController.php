<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Estado_civil;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class Estado_civilController extends Controller {
	public $modulo          = "estado civil";
	public $path_controller = "estado_civil";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Estado_civil();
	}

	public function form($id = null) {
		$datos["path_controller"] = $this->path_controller;
		$datos["modulo"]          = $this->modulo;
		$datos["filtro"]          = $this->filtros([2]);
		$datos["prefix"]          = "";
		$datos["data"]            = [];
		if ($id != null):
			$datos["data"] = Estado_civil::Select()->find($id);
		endif;

		return $datos;
	}

	public function index() {
		return view("{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$objeto = Estado_civil::Select();
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
		return view("{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			'descripcion' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "descripcion")->ignore($request->id, "id")],
		]);

		return DB::transaction(function () use ($request) {
			$obj = Estado_civil::withTrashed()->find($request->id);
			if (is_null($obj)) {
				$obj = new Estado_civil();
			}

			$obj->fill($request->all());
			$obj->save();
			return response()->json($obj);
		});
	}

	public function edit($id) {
		return view("{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {

		$obj = Estado_civil::withTrashed()->find($request->id);
		if ($request->accion == "eliminar"):
			$obj->delete();
			return response()->json();
		endif;
		$obj->restore();
		return response()->json();
	}
}
