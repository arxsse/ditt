<?php
namespace App\Models\derechoautor;
use TCPDF;

class Pdftcp extends TCPDF {

	function SetLineWidth($width) {
		parent::SetLineWidth($width);
		return $this;
	}

	function SetDash($black = null, $white = null) {
		if ($black !== null) {
			$s = sprintf('[%.3F %.3F] 0 d', $black, $white);
		} else {
			$s = '[] 0 d';
		}
		$this->_out($s);
	}

	function cortartxt($pdf, $text, $width, $suffix = '...', $font = 'helvetica', $style = 'B', $size = 12) {
		$pdf->SetFont($font, $style, $size);
		$suffixWidth = $pdf->GetStringWidth($suffix);

		if ($pdf->GetStringWidth($text) <= $width) {
			return $text; // No hace falta recortar
		}

		// Recorta el texto carácter por carácter hasta que encaje
		while ($pdf->GetStringWidth($text) + $suffixWidth > $width) {
			$text = mb_substr($text, 0, -1, 'UTF-8');
		}

		return $text . $suffix;
	}

	function Header() {}
	function Footer() {}

	// Formato 1 cabecera
	public function formato1_cabecera($titulo) {
		$y = $this->GetY();
		$x = $this->GetX();

		$this->SetY($y);
		$this->SetX($x);

		// Márgenes actuales
		$left   = $this->GetX();
		$top    = $this->GetY();
		$right  = $this->getPageWidth() - $this->getMargins()['right'];
		$bottom = $this->getPageHeight() - $this->getMargins()['bottom'];
		$this->Rect($this->getMargins()['left'], $this->getMargins()['top'], $this->getPageWidth() - $this->getMargins()['left'] - $this->getMargins()['right'], $this->getPageHeight() - $this->getMargins()['top'] - $this->getMargins()['bottom']);

		$this->Image(public_path('img/logo_indecopi.png'), 10, 10, 75, '', 'PNG');

		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 10, 'F-DDA-02/02', 1, 0, 'R');

		$this->Ln(20);

		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(0, 6, 'DIRECCIÓN DE DERECHO DE AUTOR', 0, 1, 'C');

		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(0, 6, 'SOLICITUD DE REGISTRO DE SOFTWARE Y BASE DE DATOS', 0, 1, 'C');
		$this->Ln(1);

		$this->SetX($x + 27.5);
		$this->SetFont('helvetica', '', 8);
		$this->MultiCell(135, 8, 'Declaro bajo juramento que todos los datos consignados en el presente formato corresponden a la verdad', "T", 'C');
		$this->Ln(5);
	}

	// Formato 1
	public function formato1($data) {
		$y = $this->GetY();
		$x = $this->GetX();

		$this->SetY($y);
		$this->SetX($x);

		// --- REQUISITOS DE SOFTWARE ---
		$this->SetX($x + 55);
		$this->SetFont('helvetica', '', 9);
		$this->Cell(80, 6, 'REQUISITOS DE SOFTWARE', "TLR", 1, 'L');

		$this->SetX($x + 55);
		$this->Cell(60, 6, '1. Código Fuente', "L", 0, 'L');
		$this->Cell(20, 6, 'SI [X]  NO [ ]', "R", 1);

		$this->SetX($x + 55);
		$this->Cell(60, 6, '2. Ejecutables o Memoria Descriptiva', "L", 0, 'L');
		$this->Cell(20, 6, 'SI [X]  NO [ ]', "R", 1);

		$this->SetX($x + 55);
		$this->Cell(60, 6, '3. Manual del usuario', "LB", 0, 'L');
		$this->Cell(20, 6, 'SI [X]  NO [ ]', "RB", 1);

		$this->Ln(8);

		// --- SECCIÓN 1. DATOS DEL SOLICITANTE ---
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 6, '1. DATOS DEL SOLICITANTE', 0, 1, 'L');
		$this->Ln(2);

		$this->SetFont('helvetica', '', 9);

// Fila 1: Persona Natural / Persona Jurídica
		$this->Cell(95, 8, '[ ] PERSONA NATURAL', 1, 0, 'L');
		$this->Cell(95, 8, '[X] PERSONA JURÍDICA (*)', 1, 1, 'L');

// Fila 2: Autor / Titular
		$this->Cell(190, 8, 'Puedes marcar más de una     Autor [ ]     Titular [ ]', 1, 1, 'L');

// Fila 3: Sexo
		$this->Cell(190, 8, 'Sexo:    M [ ]     F [ ]', 1, 1, 'L');

// Fila 4: Tipo de empresa
		$this->Cell(190, 8, 'Micro [ ]     Pequeña [ ]     Mediana [ ]     Otra: UNIVERSIDAD', 1, 1, 'L');

// Fila 5: La empresa es
		$this->Cell(190, 8, 'La empresa es:     Productor [ ]     Titular [ ]', 1, 1, 'L');

// Fila 6: Nombre institución
		$this->MultiCell(190, 8, 'UNIVERSIDAD NACIONAL DE SAN MARTÍN', 1, 'L', 0, 1);

// Fila 7: Documento con casillas
		$this->MultiCell(190, 8,
			'DOCUMENTO (marcar y llenar según corresponda):     Persona Natural [ ]     DNI [ ]     C.E. [ ]     PASAPORTE [ ]     Persona Jurídica [ ]     RUC [X]',
			1, 'L', 0, 1
		);

// Fila 8: Número de documento y nacionalidad (dos columnas)
		$this->Cell(95, 14, "20160766191\nNúmero de Documento", 1, 0, 'C', false, '', 1, false, 'C', 'C');
		$this->Cell(95, 14, "PERUANA\nNacionalidad / País de Constitución", 1, 1, 'C', false, '', 1, false, 'C', 'C');

// Fila 9: Representante legal y teléfono
		$this->Cell(140, 14, "GUSTAVO RÍOS PANDURO\nRepresentante Legal (Llenado obligatorio en caso de ser Persona Jurídica)", 1, 0, 'L', false, '', 1, false, 'T', 'C');
		$this->Cell(50, 14, "932646231\nTeléfono fijo y/o celular", 1, 1, 'L', false, '', 1, false, 'T', 'C');

// Nota al pie
		$this->SetFont('helvetica', 'I', 7);
		$this->MultiCell(190, 8, "(*) De acuerdo con el D.S. 013-2013-PRODUCE será considerada como microempresa...", 0, 'L');

		// --- SECCIÓN 2. DATOS DE LA OBRA ---
		$this->Ln(4);
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 6, '2. DATOS DE LA OBRA', 0, 1);

		$this->SetFont('helvetica', '', 9);
// Título de obra con cuadro grande
		$this->MultiCell(190, 10, "SOFTWARE TEST DE ORIENTACIÓN VOCACIONAL POR ÁREA DE PREFERENCIA", 1, 'C');

// Subtítulo
		$this->SetFont('helvetica', '', 9);
		$this->Cell(0, 6, "Título de Obra", 0, 1, 'L');

// Primera fila de opciones
		$this->Cell(63, 8, "¿La obra se publicó?   SI [ ]   NO [X]", 1, 0);
		$this->Cell(63, 8, "¿La obra es derivada?   SI [ ]   NO [X]", 1, 0);
		$this->Cell(64, 8, "¿Cuál es el país de origen de la obra?", 1, 1);

// Segunda fila fechas
		$this->Cell(63, 8, "¿Cuándo se terminó la obra?   ___/___/____", 1, 0);
		$this->Cell(63, 8, "¿Cuándo se publicó la obra?   ___/___/____", 1, 0);
		$this->Cell(64, 8, "", 1, 1);

// Datos si es derivada
		$this->MultiCell(190, 8, "En caso la obra sea derivada, llenar los siguientes datos:\n\nTítulo de la obra originaria:\n\nAutor de la obra originaria:\n\nTitular de la obra originaria:", 1, 'L');

		$this->SetFont('helvetica', 'I', 7);
		$this->MultiCell(190, 6, "Obra Derivada: Es aquella basada en otra obra ya existente, ejemplo adaptación, arreglo, traducción, resumen u otra transformación de la obra originaria.", 1, 'L');

// --- SECCIÓN 3. PAGO DE TASA ADMINISTRATIVA ---
		$this->Ln(4);
		$this->SetFont('helvetica', 'B', 10);
		$this->Cell(0, 6, '3. PAGO DE TASA ADMINISTRATIVA (No llenar si adjunta voucher)', 0, 1);

		$this->SetFont('helvetica', '', 9);
		$this->Cell(95, 8, "N° de Operación", 1, 0);
		$this->Cell(95, 8, "Fecha de pago   ___/___/____", 1, 1);

	}

}
