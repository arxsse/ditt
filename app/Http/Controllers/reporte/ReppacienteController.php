<?php
namespace App\Http\Controllers\reporte;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\Persona;
use App\Models\recepcion\Cama;
use App\Models\recepcion\Exceltcp;
use App\Models\recepcion\Pdftcp;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;

class ReppacienteController extends Controller {
	public $modulo          = "paciente";
	public $path_padre      = "reporte";
	public $path_controller = "reppaciente";

	public function __construct() {
		foreach (Boton::get() as $key => $value):
			$this->middleware('permission:' . $value["funcion"] . '-' . $this->path_controller . '_' . session('auth_empresa') . '_' . session('auth_rol') . '', ['only' => [$value["funcion"]]]);
		endforeach;
	}

	public function form($id = null) {
		$datos["modulo"]          = $this->modulo;
		$datos["path_padre"]      = $this->path_padre;
		$datos["path_controller"] = $this->path_controller;
		$datos["prefix"]          = "";
		$datos["empresa"]         = (auth()->user()->super_admin) ? Empresa::get() : Empresa::find(auth()->user()->persona->idempresa);
		return $datos;
	}

	public function index() {
		return view("{$this->path_padre}.{$this->path_controller}.index", $this->form());
	}

	public function generar_reporte(Request $request) {
		$this->validate($request, [
			'idempresa'      => 'required',
			'idarea'         => 'required',
			'idespecialidad' => 'required',
			'rangofecha'     => 'required',
		]);
		if (! isset($request->validacion)): return 1;endif;

		$idempresa      = $request->idempresa;
		$idarea         = $request->idarea;
		$idespecialidad = $request->idespecialidad;
		$rangofecha     = $request->rangofecha;
		$accion         = $request->accion;
		$fecha_ini      = explode(" - ", $rangofecha)[0];
		$fecha_fin      = explode(" - ", $rangofecha)[1];

		$query = Cama::select("cama.*")->selectRaw("EXTRACT(YEAR from age(cama.fecha_nacimiento)) as edad")
			->with(["empresa", "area", "especialidad", "persona", "creador"])
			->join("configuracion.area", "area.id", "cama.idarea")
			->join("configuracion.especialidad as espe", "espe.id", "cama.idespecialidad")
			->where("cama.idempresa", $idempresa)->whereBetween('cama.fecha_atencion', [$fecha_ini, $fecha_fin])
			->orderBy("area.orden")->orderBy("espe.orden");

		if ($idarea != "#"):
			$query->where("cama.idarea", $idarea);
		endif;

		if ($idespecialidad != "#"):
			$query->where("cama.idespecialidad", $idespecialidad);
		endif;
		$data = $query->get();

		if ($accion == "pdf"):
			$tcpdf = new Pdftcp($idempresa, 'P', 'mm', 'A4');
			$tcpdf->SetMargins(10, 26, 10);
			$tcpdf->AddPage('L', 'A4');
			$titulo   = "Reporte paciente";
			$titulo_p = "Reporte paciente";

			$tcpdf->reppac_cabecera($titulo);
			$tcpdf->reppac_cuerpo($data);
			$tcpdf->SetTitle($titulo);
			$tcpdf->Output($titulo_p . ".pdf");

		elseif ($accion == "excel"):
			$excel    = new Exceltcp();
			$titulo   = "Reporte paciente";
			$titulo_p = "Reporte paciente_" . date("d-m-Y");
			$excel->reppac($data, $titulo);
			$excel->descargar($titulo_p . ".xlsx");
		endif;
	}
}
