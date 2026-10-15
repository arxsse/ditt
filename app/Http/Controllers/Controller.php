<?php
namespace App\Http\Controllers;

use App\Models\caja\Apertura;
use App\Models\configuracion\Empresa;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $driver_current = "";
	protected $auth_facultad;

	public $filtros = [
		// 0 --> Empresa
		[
			[
				"tipo"    => "empresa",
				"texto"   => "Empresas",
				"filtro"  => '-1',
				"default" => true,
			],
		],

		// 1 --> Sucursal
		[
			[
				"tipo"    => "sucursal",
				"texto"   => "Sucursales",
				"filtro"  => '-1',
				"default" => true,
			],
		],

		// 2 --> Estado
		[
			[
				"tipo"    => "estado",
				"texto"   => "Activos",
				"filtro"  => '1',
				"default" => true,
			],
			[
				"tipo"    => "estado",
				"texto"   => "Eliminados",
				"filtro"  => 'onlyTrashed();',
				"default" => false,
			],
			[
				"tipo"    => "estado",
				"texto"   => "Activos y eliminados",
				"filtro"  => 'withTrashed();',
				"default" => false,
			],
		],
	];

	public function __construct() {
		$this->driver_current = DB::getDriverName();
	}

	public function filtros($array_filtro, $tabla = null) {
		// 0 --> Empresa
		// 1 --> Sucursal
		// 2 --> Estado

		$temp_filtro = [];
		foreach ($array_filtro as $value):
			switch ($value) {
			case 0:
				array_push($temp_filtro, $this->filtros[$value]);
				foreach (Empresa::get() as $row):
					array_push($temp_filtro[$value], ["tipo" => "empresa", "texto" => $row["razonsocial"], "filtro" => $row["id"], "default" => false]);
				endforeach;
				break;
			default:
				array_push($temp_filtro, $this->filtros[$value]);
				break;
			}
		endforeach;
		return $temp_filtro;
	}

	public function numero_romano(int $num) {
		if ($num <= 0) {
			return "-";
		}

		$conversion = [
			'M'  => 1000,
			'CM' => 900,
			'D'  => 500,
			'CD' => 400,
			'C'  => 100,
			'XC' => 90,
			'L'  => 50,
			'XL' => 40,
			'X'  => 10,
			'IX' => 9,
			'V'  => 5,
			'IV' => 4,
			'I'  => 1,
		];

		$romano = '';
		foreach ($conversion as $en_romano => $normal) {
			$matches = (int) $num / $normal;
			$romano .= str_repeat($en_romano, $matches);
			$num = $num % $normal;
		}
		return $romano;
	}

	public function caja_actual() {
		$data               = [];
		$caja               = Apertura::where("idempresa", auth()->user()->persona->idempresa)->where("idsucursal", auth()->user()->idsucursal)->where("proceso", true)->first();
		$data["idapertura"] = (is_null($caja)) ? null : $caja["id"];
		$data["idcaja"]     = ($data["idapertura"] == null) ? null : $caja["idcaja"];
		return $data;
	}
}