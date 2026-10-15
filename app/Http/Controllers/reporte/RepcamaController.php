<?php
namespace App\Http\Controllers\reporte;
use App\Http\Controllers\Controller;
use App\Models\configuracion\Empresa;
use App\Models\configuracion\Especialidad;
use App\Models\Persona;
use App\Models\recepcion\Exceltcp;
use App\Models\recepcion\Pdftcp;
use App\Models\seguridad\Boton;
use Illuminate\Http\Request;

class RepcamaController extends Controller {
	public $modulo          = "cama";
	public $path_padre      = "reporte";
	public $path_controller = "repcama";

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
		return view("{$this->path_padre}.reppaciente.index", $this->form());
	}

	public function generar_reporte(Request $request) {
		$this->validate($request, [
			'idempresa'      => 'required',
			'idarea'         => 'required',
			'idespecialidad' => 'required',
		]);
		if (! isset($request->validacion)): return 1;endif;

		$idempresa      = $request->idempresa;
		$idarea         = $request->idarea;
		$idespecialidad = $request->idespecialidad;
		$accion         = $request->accion;

		$query = Especialidad::select("especialidad.*")->with(["empresa", "area", "responsable_principal.responsable"])
			->join("configuracion.area", "area.id", "especialidad.idarea")
			->where("especialidad.idempresa", $idempresa)
			->orderBy("area.orden")->orderBy("especialidad.orden");

		if ($idarea != "#"):
			$query->where("especialidad.idarea", $idarea);
		endif;

		if ($idespecialidad != "#"):
			$query->where("id", $idespecialidad);
		endif;
		$data = $query->get();

		if ($accion == "pdf"):
			$tcpdf = new Pdftcp($idempresa, 'P', 'mm', 'A4');
			$tcpdf->SetMargins(10, 26, 10);
			$tcpdf->AddPage();
			$titulo   = "Reporte cama";
			$titulo_p = "Reporte cama";

			$tcpdf->repcama_cabecera($titulo);
			$tcpdf->repcama_cuerpo($data);
			$tcpdf->SetTitle($titulo);
			$tcpdf->Output($titulo_p . ".pdf");

		elseif ($accion == "excel"):
			$excel    = new Exceltcp();
			$titulo   = "Reporte cama";
			$titulo_p = "Reporte cama_" . date("d-m-Y");
			$excel->repcama($data, $titulo);
			$excel->descargar($titulo_p . ".xlsx");
		endif;
	}
}
