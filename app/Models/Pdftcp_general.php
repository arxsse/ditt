<?php
namespace App\Models;
use App\Models\configuracion\Empresa;
use TCPDF;

class Pdftcp_general extends TCPDF {
	public $idempresa;
	public function __construct($idempresa, $pagina, $mm, $tipo) {
		parent::__construct();
		$this->idempresa = $idempresa;
	}

	function header_general($this1, $idempresa) {
		$dataempresa = Empresa::find($idempresa);
		//$ubicacion   = $dataempresa->path_file . $dataempresa->id . "/" . str_replace(" ", "%20", $dataempresa->rutaimagen);
		//$ubicacion   = str_replace(env('APP_URL'), $_SERVER['DOCUMENT_ROOT'] . env('APP_MAIN'), $ubicacion);
		$ubicacion = "public/img/logo.jpg";

		$this1->image($ubicacion, 10, 2, 20, 20);

		$this1->SetXY(32, 5);
		$this1->setFont("Times", "B", "10");
		$this1->SetTextColor(0, 0, 0);
		$this1->Cell(0, 0, $dataempresa->razonsocial, 0, 1, "L");

		$this1->SetX(32);
		$this1->setFont("Times", "", "10");
		$this1->Cell(135, 0, $dataempresa->direccion, 0, 0, "L");

		$this1->setFont("Times", "", "10");
		$this1->Cell(0, 0, "Fecha : " . date("d-m-Y"), 0, 1, "R");

		$this1->SetX(32);
		$this1->setFont("Times", "", "10");
		$this1->Cell(135, 0, "RUC : " . $dataempresa->ruc, 0, 0, "L");

		$this1->setFont("Times", "", "10");
		$this1->Cell(0, 0, "Hora : " . date("h:i:s a"), 0, 1, "R");

		$this1->Ln(5);

		$this1->SetLineWidth(0.4);
		$this1->Line(10, $this1->GetY(), $this1->GetPageWidth() - 10, $this1->GetY());
		$this1->SetLineWidth(0.2);

	}
}