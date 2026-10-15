<?php
namespace App\Http\Controllers\derechoautor;
use App\Http\Controllers\Controller;
use App\Models\derechoautor\Derechoautor;
use App\Models\derechoautor\Derechoautor_integrante;
use App\Models\derechoautor\Derechoautor_requisito;
use App\Models\derechoautor\Pdftcp;
use App\Models\derechoautor\Proceso;
use App\Models\derechoautor\Tipoderechoautor_requisitos;
use App\Models\Persona;
use App\Models\seguridad\Boton;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DerechoautorController extends Controller {
	public $modulo          = "solicitud";
	public $path_padre      = "derechoautor";
	public $path_controller = "derechoautor";
	public $model           = null;

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
		$this->model = new Derechoautor();
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "";
		$datos["filtro"]          = $this->filtros([2]);
		$datos["proceso"]         = Proceso::where("id", "!=", 6)->get();

		$datos["data"] = [];
		if ($id != null):
			$datos["data"] = Derechoautor::withTrashed()->find($id);
		endif;
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function grilla(Request $request) {
		$objeto = Derechoautor::select("derechoautor.*")->with(["tipoderechoautor", "proceso", "integranteprin.persona"]);

		// Filtro estado
		if ($request->estado != 1):
			eval('$objeto->' . $request->estado);
		endif;

		return DataTables::of($objeto)
			->addIndexColumn()
			->addColumn("icono", function ($objeto) {
				return "<i class='{$objeto->icono}'></i>";
			})
			->addColumn("detalle", function ($objeto) {
				return '<span class="badge bg-label-primary link" onclick="abrir_show(event, this, ' . $objeto->id . ')" >Ver detalle</span>';
			})
			->rawColumns(["icono", "estado", "detalle"])
			->make(true);
	}

	public function proceso($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form_proceso", $this->form($id));
	}

	public function store_proceso(Request $request) {
		$this->validate($request, [
			'idproceso'     => 'required',
			'observacion'   => 'required_if:idproceso,2|required_if:idproceso,3',
			'urlresolucion' => 'required_if:idproceso,5',
		], [
			"observacion.required_if"   => "El campo observación es obligatorio.",
			"urlresolucion.required_if" => "El campo url resolución es obligatorio.",

		]);

		return DB::transaction(function () use ($request) {
			$now         = Carbon::now();
			$hora_actual = $now->format("h:i:s a");

			$obj = Derechoautor::withTrashed()->find($request->id);
			$obj->fill($request->all());
			$obj->idpais        = 1;
			$obj->idempresa     = 1;
			$obj->fecha_proceso = date("Y-m-d");
			$obj->hora_proceso  = $hora_actual;
			$obj->save();
			return response()->json();
		});
	}

	public function store(Request $request) {
	}

	public function edit($id) {
		return view("{$this->path_padre}.{$this->path_controller}.form", $this->form($id));
	}

	public function show($id) {
		$datos["modulo"]              = $this->modulo;
		$datos["path_padre"]          = $this->path_padre;
		$datos["path_controller"]     = $this->path_controller;
		$datos["data"]                = Derechoautor::select("derechoautor.*")->with(["tipoderechoautor", "proceso"])->withTrashed()->find($id);
		$datos["data"]["integrantes"] = Derechoautor_integrante::with(["persona.distrito_actual.provincia.departamento"])->where("idderechoautor", $id)->orderBy("principal", "DESC")->orderBy("orden")->get();
		$datos["data"]["requisitos"]  = Derechoautor_requisito::where("idderechoautor", $id)->orderBy("orden")->get();
		$datos["data"]["formatos"]    = Tipoderechoautor_requisitos::where("idtipoderechoautor", $datos["data"]->idtipoderechoautor)->where("seenvia", false)->get();

		return view("{$this->path_padre}.{$this->path_controller}.show", $datos);
	}

	public function formateriapdf(Request $request) {
		$tcpdf = new Pdftcp('P', 'mm', 'A4', true, 'UTF-8', false);
		$tcpdf->SetMargins(10, 10, 10);
		$tcpdf->AddPage();

		$data = Derechoautor::withTrashed()->find($request->id);

		$titulo_pdf = "Ticket garantia";
		$titulo     = "Registro de garantia";
		$tcpdf->formato1_cabecera($titulo);
		$tcpdf->formato1($data);

		$tcpdf->SetTitle($titulo_pdf);
		$tcpdf->Output($titulo_pdf . ".pdf");
	}

	public function formateria(Request $request) {
		$datos["data"]          = Derechoautor::withTrashed()->with(["empresa"])->find($request->id);
		$datos["representante"] = Persona::where("representante", true)->first();
		$datos["urlejemplo"]    = $request->urlejemplo;
		$datos["fecha_actual"]  = Carbon::now()->translatedFormat('d \d\e F \d\e Y');

		$page                 = isset($request->page) ?? 1;
		$datos["integrantes"] = Derechoautor_integrante::with(["persona"])->where("idderechoautor", $request->id)->paginate(3);

		return view("{$this->path_padre}.{$this->path_controller}.formatos.{$datos["data"]->idtipoderechoautor}.formato{$datos["urlejemplo"]}", $datos);
	}

	public function destroy(Request $request) {
		$obj = Derechoautor::withTrashed()->find($request->id);
		if ($request->accion == "eliminar"):
			$obj->delete();
			return response()->json();
		endif;
		$obj->restore();
		return response()->json();
	}
}
