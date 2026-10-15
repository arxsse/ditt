<?php
namespace App\Http\Controllers\configuracion;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\Departamento;
use App\Models\Pais;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class EmpresaController extends Controller {
	public $modulo          = "empresa";
	public $path_padre      = "configuracion";
	public $path_controller = "empresa";
	public $model           = null;
	public $paht_file       = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model     = new Empresa();
		$this->paht_file = $this->model->getPathFile();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "";
		$datos["filtro"]          = $this->filtros([2]);
		$datos["departamento"]    = Departamento::get();
		$datos["pais"]            = (auth()->user()->super_admin) ? Pais::get() : Pais::find(auth()->user()->persona->idpais);

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Empresa::withTrashed()->with("distrito.provincia")->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$objeto = Empresa::select();

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
			'idpais' => ['required'],
			'ruc'    => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "ruc")->ignore($request->id, "id")],
			'razonsocial' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "razonsocial")->ignore($request->id, "id")],
			'abreviatura' => ['required'],
			'oficina' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "razonsocial")->ignore($request->id, "id")],
			'abreviatura_oficina' => ['required'],
			'direccion' => ['required'],
		]);

		return DB::transaction(function () use ($request) {

			$file_paht = $file_size = $file_name = null;
			if ($request->files_tmp_total > 0):
				$file_paht = ($request->hasFile("files_tmp-0")) ? $request->file("files_tmp-0") : null;
				$file_size = ($request->hasFile("files_tmp-0")) ? filesize($file_paht) : $request->input("files_tmp-0")["size"];
				$file_name = ($request->hasFile("files_tmp-0")) ? $_FILES["files_tmp-0"]['name'] : $request->input("files_tmp-0")["name"];
			endif;

			$obj = Empresa::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Empresa();
			endif;
			$obj->fill($request->all());
			$obj->ubigeo     = $request->iddistrito;
			$obj->rutaimagen = $file_name;
			$obj->sizeimagen = $file_size;
			if ($obj->save()):
				if (! is_null($file_paht)):
					$paht_file = $this->paht_file . $obj->id . "/";
					if (! file_exists($paht_file)):
						mkdir($paht_file, 0777, true);
						chmod($paht_file, 0755);
					endif;
					copy($file_paht->getRealPath(), $paht_file . $file_name);
				endif;
			endif;
			return response()->json($obj);
		});
	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {
		$obj = Empresa::withTrashed()->find($request->id);
		if ($request->accion == "eliminar") {
			$obj->delete();
			return response()->json();
		}
		$obj->restore();
		return response()->json();
	}
}
