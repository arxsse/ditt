<?php
namespace App\Http\Controllers\derechoautor;
use App\Http\Controllers\Controller;
use App\Models\derechoautor\Tipoderechoautor;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class TipoderechoautorController extends Controller {
	public $modulo          = "tipo";
	public $path_padre      = "derechoautor";
	public $path_controller = "tipoderechoautor";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Tipoderechoautor();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "";
		$datos["filtro"]          = $this->filtros([2]);

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Tipoderechoautor::withTrashed()->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$objeto = Tipoderechoautor::select("tipoderechoautor.*");

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
			->rawColumns(["icono", "estado"])
			->make(true);
	}

	public function create() {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			'categoria'   => 'required',
			'icono'       => 'required',
			'descripcion' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "descripcion")->ignore($request->id, "id")],
			'orden'       => ['required', 'numeric'],
			'resumen'     => 'required',

		]);

		return DB::transaction(function () use ($request) {
			$obj = Tipoderechoautor::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Tipoderechoautor();
			endif;
			$obj->fill($request->all());
			$obj->save();
			return response()->json();
		});
	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {
		$obj = Tipoderechoautor::withTrashed()->find($request->id);
		if ($request->accion == "eliminar"):
			$obj->delete();
			return response()->json();
		endif;
		$obj->restore();
		return response()->json();
	}
}
