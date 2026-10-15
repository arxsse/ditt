<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use App\Models\Provincia;

class UbigeoController extends Controller {
	public function get_provincia($iddepartamento) {
		$provincia = Provincia::where('iddepartamento', $iddepartamento)->get();
		return response()->json($provincia);
	}

	public function get_distrito($idprovincia) {
		$distrito = Distrito::where('idprovincia', $idprovincia)->get();
		return response()->json($distrito);
	}
}
