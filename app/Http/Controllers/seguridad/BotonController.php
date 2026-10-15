<?php
namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class BotonController extends Controller {
	public $modulo          = "botón";
	public $path_padre      = "seguridad";
	public $path_controller = "boton";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Boton();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "boton";
		$datos["filtro"]          = $this->filtros([0, 2]);
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Boton::withTrashed()->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		$objeto    = Boton::select();

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
			->rawColumns(["icono", "estado"])
			->make(true);
	}

	public function create() {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			"idempresa"   => "required",
			"descripcion" => "required",
			"funcion"     => ["required", Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "funcion")->ignore($request->id, "id")],
			"orden"       => ["nullable", "numeric"],
		]);

		return DB::transaction(function () use ($request) {
			$obj = Boton::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Boton();
			endif;
			$obj->fill($request->all());
			$obj->mostrar  = (isset($request->mostrar)) ? true : false;
			$obj->es_boton = (isset($request->es_boton)) ? true : false;
			$obj->save();
			return response()->json($obj);
		});

	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {

		if ($request->accion == "eliminar") {
			Boton::find($request->id)->delete();
			return response()->json();
		}
		Boton::withTrashed()->find($request->id)->restore();
		return response()->json();
	}

	public function get_boton(Request $request) {
		$obj = Boton::where("idempresa", $request->idempresa)->where("mostrar", true)->orderBy("orden")->get();
		return response()->json($obj);
	}
}