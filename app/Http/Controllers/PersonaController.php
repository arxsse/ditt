<?php
namespace App\Http\Controllers;
use App\Models\configuracion\Empresa;
use App\Models\configuracion\Facultad;
use App\Models\Departamento;
use App\Models\Estado_civil;
use App\Models\Persona;
use App\Models\seguridad\Boton;
use App\Models\Sexo;
use App\Models\Tipopersona;
use App\Models\Tipo_documento_identidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class PersonaController extends Controller {
	public $modulo                = "persona";
	public $path_controller       = "persona";
	public $model                 = null;
	public $codigo_cliente        = "Cl";
	public $codigo_administrativo = "Ad";

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Persona();
	}

	public function form($id = null) {
		$datos["path_controller"]          = $this->path_controller;
		$datos["modulo"]                   = $this->modulo;
		$datos["filtro"]                   = $this->filtros([0, 2]);
		$datos["prefix"]                   = "persona";
		$datos["tipo_documento_identidad"] = Tipo_documento_identidad::get();
		$datos["sexo"]                     = Sexo::get();
		$datos["tipo_persona"]             = Tipopersona::orderBy("id")->get();
		$datos["facultad"]                 = Facultad::orderBy("orden")->get();
		$datos["estado_civil"]             = Estado_civil::get();
		$datos["departamento"]             = Departamento::get();
		$datos["empresa"]                  = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);
		$datos["data"]                     = [];
		if ($id != null):
			$datos["data"] = Persona::withTrashed()->with('distrito_procedencia.provincia')->with('distrito_actual.provincia')->find($id);
		endif;

		return $datos;
	}

	public function index() {
		return view("{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$idempresa = (auth()->user()->super_admin) ? null : auth()->user()->persona->idempresa;
		$objeto    = Persona::Select();

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
		return view("{$this->path_controller}.form", $this->form());
	}

	public function store(Request $request) {
		$rango = Tipo_documento_identidad::where('id', $request->idtipo_documento_identidad)->value('rango');
		$this->validate($request, [
			'idempresa'                  => 'required',
			'idtipopersona'              => 'required',
			'idtipo_documento_identidad' => 'required',
			'numero_documento_identidad' => ['required', 'numeric', 'digits:' . $rango, Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "numero_documento_identidad")->ignore($request->id, "id")],
			'apellido_paterno'      => 'required',
			'apellido_materno'      => 'required',
			'nombres'               => 'required',
			'iddepartamento_actual' => 'required',
			'idprovincia_actual'    => 'required',
			'iddistrito_actual'     => 'required',

			'fecha_nacimiento'      => "required|date|date_format:d-m-Y",
			'tipocalle'             => 'required',
			'direccion'             => 'required',

			"correo"                => ['required', 'email:rfc,dns'],
			'celular'               => 'required',
			'idsexo'                => 'required',
		]);

		return DB::transaction(function () use ($request) {
			$obj = Persona::withTrashed()->find($request->id);
			if (is_null($obj)):
				$obj = new Persona();
			endif;
			$obj->fill($request->all());
			$obj->ubigeo_procedencia = $request->iddistrito_procedencia;
			$obj->ubigeo_actual      = $request->iddistrito_actual;
			$obj->nombre_completo    = $request->nombres . " " . $request->apellido_paterno . " " . $request->apellido_materno;
			if ($obj->save()):
				return response()->json(Persona::select("persona.*")->with(["estado_civil", "distrito_actual.provincia.departamento"])->find($obj->id));
			endif;
		});
	}

	public function edit($id) {
		return view("{$this->path_controller}.form", $this->form($id));
	}

	public function destroy(Request $request) {

		$obj = Persona::withTrashed()->find($request->id);
		if ($request->accion == "eliminar"):
			$obj->delete();
			return response()->json();
		endif;
		$obj->restore();
		return response()->json();
	}

	public function buscar($search, $tipo = null, Request $request) {
		$query = Persona::select("persona.*")->with(["estado_civil", "distrito_actual.provincia.departamento"]);

		if ($tipo != null):
			$query->join("tipopersona as tipo", "persona.idtipopersona", "tipo.id")->where("tipo.codigo", $tipo);
		endif;

		$query->where(function ($q) use ($search) {
			$q->where('persona.numero_documento_identidad', 'like', '%' . $search . '%')
				->orWhere('persona.nombres', 'ilike', '%' . $search . '%')
				->orWhere('persona.apellido_paterno', 'ilike', '%' . $search . '%')
				->orWhere('persona.apellido_materno', 'ilike', '%' . $search . '%')
				->orWhere('persona.nombre_completo', 'ilike', '%' . $search . '%');
		});

		$datos["search"] = $query->take(10)->get();
		if (count($datos["search"]) == 0):
			$datos["search"] = [["id" => -1, "numero_documento_identidad" => $search, "nombre_completo" => ""]];
		endif;
		return $datos;
	}

	public function consulta_sunat($documento) {
		$url   = (mb_strlen($documento) == 11) ? "ruc" : "dni";
		$token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
		$curl  = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL            => "https://api.apis.net.pe/v1/" . $url . "?numero=" . $documento . "&" . $token,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => '',
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_2TLS,
			CURLOPT_CUSTOMREQUEST  => 'GET',
		]);

		$response = curl_exec($curl);
		curl_close($curl);

		$data = json_decode($response, true);
		if (is_array($data)):
			return response()->json($data);
		endif;

		$data            = [];
		$data["message"] = "Sin datos";
		return response()->json($data);

	}

}
