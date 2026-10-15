<?php
namespace App\Http\Controllers\seguridad;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\seguridad\Boton;
use App\Models\seguridad\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class UsuarioController extends Controller {
	public $modulo          = "usuario";
	public $path_padre      = "seguridad";
	public $path_controller = "usuario";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new User();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "usuario";
		$datos["filtro"]          = $this->filtros([0, 2]);
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);

		$datos["data"] = [];
		if ($id != null) {
			$datos["data"]                    = User::withTrashed()->with('persona')->find($id);
			$datos["data"]["idroles"]         = array_column(DB::table("seguridad.usuario_role")->selectRaw("role_id")->where('model_id', $datos["data"]->id)->get()->toArray(), "role_id");
			$datos["data"]["nombre_completo"] = $datos["data"]["persona"]["nombre_completo"];
			$datos["data"]["idempresa"]       = $datos["data"]["persona"]["idempresa"];
		}
		return $datos;
	}

	public function form_reset($id = null) {
		$datos["path_controller"] = $this->path_controller;
		$datos["path_padre"]      = $this->path_padre;
		$datos["modulo"]          = $this->modulo;
		$datos["prefix"]          = "usuario";
		$datos["data"]            = [];
		if ($id != null) {
			$datos["data"]                    = User::withTrashed()->with('persona')->find($id);
			$datos["data"]["nombre_completo"] = $datos["data"]["persona"]["nombre_completo"];
		}
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		//$objeto    = User::select("seguridad.usuario.*")->with('persona');

		$objeto = User::select("usuario.*")->join("public.persona as p", "p.id", "usuario.idpersona")->with("persona");

		// Filtro empresa
		if ($idempresa != null):
			$objeto->where("p.idempresa", $idempresa);
		elseif ($request->empresa != -1):
			$objeto->where("p.idempresa", $request->empresa);
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
			'idempresa' => 'required',
			'idpersona' => ['required', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "idpersona")->ignore($request->id, "id")],
			'idroles'   => 'required',
			'usuario'   => ['required', 'max:120', Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "usuario")->ignore($request->id, "id")],
			'password'  => ['required_without:id', 'confirmed'],
		], [
			"idpersona.unique" => "La persona ya tiene un usuario asigando.",
		]);

		return DB::transaction(function () use ($request) {
			$obj      = User::withTrashed()->find($request->id);
			$password = null;
			if (is_null($obj)):
				$obj      = new User();
				$password = Hash::make($request->password);
			else:
				DB::table('seguridad.usuario_role')->where('model_id', $request->id)->delete();
			endif;

			$obj->idrole = $request->idroles[0];
			$obj->fill($request->all());
			if (! is_null($password)):
				$obj->password = $password;
			endif;

			if ($obj->save()):
				foreach ($request->idroles as $value):
					$obj->assignRole($value);
				endforeach;
			endif;
			return response()->json($obj);
		});

	}

	public function store_reset(Request $request) {
		$this->validate($request, [
			'password' => ['required', 'confirmed'],
		]);

		$obj = User::withTrashed()->find($request->id);
		if (is_null($obj)) {
			throw ValidationException::withMessages(['usuario_required' => 'Usuario no existente.']);
		} else {
			$password      = Hash::make($request->password);
			$obj->password = $password;
			$obj->save();
		}
		return response()->json($obj);

	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function reset($id) {
		return view("{$this->path_padre}.{$this->path_controller}.reset", $this->form_reset($id));
	}

	public function destroy(Request $request) {

		if ($request->accion == "eliminar") {
			User::find($request->id)->delete();
			return response()->json();
		}
		User::withTrashed()->find($request->id)->restore();
		return response()->json();
	}
}
