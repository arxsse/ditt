<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\configuracion\Facultad;
use App\Models\configuracion\Oficina;
use App\Models\Departamento;
use App\Models\derechoautor\Derechoautor;
use App\Models\derechoautor\Derechoautor_integrante;
use App\Models\derechoautor\Derechoautor_requisito;
use App\Models\derechoautor\Tipoderechoautor;
use App\Models\Persona;
use App\Models\Sexo;
use App\Models\Tipo_documento_identidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FormularioController extends Controller {
	public $modulo          = "formulario";
	public $path_padre      = "";
	public $path_controller = "formulario";
	public $token           = "jcColala2025";
	public $model           = null;
	public $paht_file       = null;

	public function __construct() {
		$this->model     = new Derechoautor();
		$this->paht_file = $this->model->getPathFile();
	}

	public function form() {
		$datos["modulo"]                   = $this->modulo;
		$datos["path_padre"]               = $this->path_padre;
		$datos["path_controller"]          = $this->path_controller;
		$datos["prefix"]                   = "";
		$datos["tipoderechoautor"]         = Tipoderechoautor::Select("tipoderechoautor.id", "tipoderechoautor.categoria", "tipoderechoautor.icono", "tipoderechoautor.descripcion", "tipoderechoautor.resumen", "tipoderechoautor.orden")->with(["requisitosform"])->orderBy("orden")->get();
		$datos["tipo_documento_identidad"] = Tipo_documento_identidad::get();
		$datos["departamento"]             = Departamento::get();
		$datos["sexo"]                     = Sexo::get();
		$datos["facultad"]                 = Facultad::orderBy("orden")->get();
		$datos["oficina"]                  = Oficina::orderBy("orden")->get();
		$datos["token"]                    = Crypt::encryptString($this->token);

		return $datos;
	}

	public function index() {
		return view('formulario', $this->form());
	}

	public function store(Request $request) {
		$this->validate($request, [
			"titulo" => ["required", Rule::unique("{$this->driver_current}.{$this->model->getTable()}", "titulo")->ignore($request->id, "id")],
			"idtipoderechoautor" => "required",
			"urlcodigofuente"    => "required_if:idtipoderechoautor,1",
		], [
			"urlcodigofuente.required_if" => "El campo URL código fuente es obligatorio",
		]);

		for ($i = 0; $i < $request->integrates_total; $i++):
			if (! isset($request["idtipo_documento_identidad$i"])):
				continue;
			endif;

			$rango = Tipo_documento_identidad::where('id', $request->{"idtipo_documento_identidad$i"})->value('rango');
			$this->validate($request, [
				"idfacultad$i"                 => "required_without:idoficina$i",
				"idofcina$i"                   => 'nullable',
				"idtipo_documento_identidad$i" => 'required',
				"numero_documento_identidad$i" => ['required', 'numeric', 'digits:' . $rango],
				"apellido_paterno$i"           => "required",
				"apellido_materno$i"           => "required",
				"nombres$i"                    => "required",

				"iddepartamento_actual$i"      => "required",
				"idprovincia_actual$i"         => "required",
				"iddistrito_actual$i"          => "required",

				"fecha_nacimiento$i"           => "required|date|date_format:d-m-Y",
				"tipocalle$i"                  => "required",
				"direccion$i"                  => "required",

				"correo$i"                     => ["required", "email:rfc,dns"],
				"celular$i"                    => "required",
				"idsexo$i"                     => "required",
			], [
				"idfacultad$i.required_without"         => "Es necesario seleccionar una facultad o una oficina.",
				"idtipo_documento_identidad$i.required" => "El campo tipo de documento identidad es obligatorio.",
				"numero_documento_identidad$i.required" => "El campo número documento identidad es obligatorio.",
				"apellido_paterno$i.required"           => "El campo apellido paterno es obligatorio.",
				"apellido_materno$i.required"           => "El campo apellido materno es obligatorio.",
				"nombres$i.required"                    => "El campo nombres es obligatorio.",

				"iddepartamento_actual$i.required"      => "El campo departamento actual es obligatorio.",
				"idprovincia_actual$i.required"         => "El campo provincia actual es obligatorio.",
				"iddistrito_actual$i.required"          => "El campo distrito actual es obligatorio.",

				"fecha_nacimiento$i.required"           => "El campo fecha nacimiento es obligatorio.",
				"fecha_nacimiento$i.date"               => "El campo fecha nacimiento debe ser una fecha válida.",
				"fecha_nacimiento$i.date_format"        => "El campo fecha nacimiento debe tener el formato Día-Mes-Año",
				"tipocalle$i.required"                  => "El campo tipo calle es obligatorio.",
				"direccion$i.required"                  => "El campo dirección es obligatorio.",

				"correo$i.required"                     => "El campo correo es obligatorio.",
				"correo$i.email"                        => "El correo no tiene un formato válido.",
				"celular$i.required"                    => "El campo celular es obligatorio.",
				"idsexo$i.required"                     => "El campo sexo es obligatorio.",
			]);
		endfor;

		$numeros = [];
		for ($i = 0; $i < $request->integrates_total; $i++):
			if (! isset($request["idtipo_documento_identidad$i"])):
				continue;
			endif;
			$numeros[$i] = $request->input("numero_documento_identidad{$i}");
		endfor;

		$duplicados = array_keys(array_filter(array_count_values($numeros), fn($count) => $count > 1));
		if (! empty($duplicados)):
			$errors = [];
			foreach ($numeros as $index => $valor):
				if (in_array($valor, $duplicados)):
					$errors["numero_documento_identidad{$index}"] = ["El número documento identidad no debe repetirse."];
				endif;
			endforeach;
			throw ValidationException::withMessages($errors);
		endif;

		$rules = [];
		for ($i = 0; $i < $request->files_tmp_total; $i++):
			$rules["files_tmp-$i"] = "required|file|mimes:pdf|max:51200";
		endfor;

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()):
			$failedField    = array_key_first($validator->errors()->messages());
			$failedFile     = $request->file($failedField);
			$failedFileName = $failedFile ? $failedFile->getClientOriginalName() : $failedField;
			throw ValidationException::withMessages([
				"required_files" => "Revise el archivo {$failedFileName}, ya que podría estar dañado o exceder el tamaño máximo permitido.",
			]);
		endif;

		return DB::transaction(function () use ($request) {
			$obj = new Derechoautor();
			$obj->fill($request->all());
			$obj->idpais    = 1;
			$obj->idempresa = 1;
			$obj->idproceso = 1;
			$obj->fecha     = date('Y-m-d');
			$obj->hora      = date("h:i:s a");
			if ($obj->save()):
				if ($request->files_tmp_total > 0):
					for ($i = 0; $i < $request->files_tmp_total; $i++):
						$file = $request->file("files_tmp-" . $i);
						if ($file):
							$file_name = $file->getClientOriginalName();
							$file_size = $file->getSize();

							$obj3                 = new Derechoautor_requisito();
							$obj3->idderechoautor = $obj->id;
							$obj3->descripcion    = pathinfo($file_name, PATHINFO_FILENAME);
							$obj3->rutadocumento  = $file_name;
							$obj3->sizedocumento  = $file_size;
							$obj3->orden          = $i + 1;
							$obj3->deleted_at     = null;

							if ($obj3->save()):
								$paht_file = $this->paht_file . $obj->id . "/";

								if (! file_exists($paht_file)):
									mkdir($paht_file, 0777, true);
									chmod($paht_file, 0755);
								endif;

								$file->move($paht_file, $file_name);
							endif;
						endif;
					endfor;
				endif;

				$index_principal = null;
				for ($i = 0; $i < $request->integrates_total; $i++):
					if (! isset($request["idtipo_documento_identidad$i"])):
						continue;
					endif;

					$obj1 = Persona::where("numero_documento_identidad", $request["numero_documento_identidad" . $i])
						->where("idtipopersona", 1)->first();

					if (is_null($obj1)):
						$obj1 = new Persona();
					endif;
					$obj1->idpais                     = 1;
					$obj1->idempresa                  = $obj->idempresa;
					$obj1->idfacultad                 = $request["idfacultad" . $i];
					$obj1->idoficina                  = $request["idoficina" . $i];
					$obj1->idtipopersona              = 1;
					$obj1->idtipo_documento_identidad = $request["idtipo_documento_identidad" . $i];
					$obj1->numero_documento_identidad = $request["numero_documento_identidad" . $i];
					$obj1->ubigeo_actual              = $request["iddistrito_actual" . $i];
					$obj1->idsexo                     = $request["idsexo" . $i];
					$obj1->nombres                    = $request["nombres" . $i];
					$obj1->apellido_paterno           = $request["apellido_paterno" . $i];
					$obj1->apellido_materno           = $request["apellido_materno" . $i];
					$obj1->nombre_completo            = $obj1->nombres . " " . $obj1->apellido_paterno . " " . $obj1->apellido_materno;
					$obj1->correo                     = $request["correo" . $i];
					$obj1->tipocalle                  = $request["tipocalle" . $i];
					$obj1->direccion                  = $request["direccion" . $i];
					$obj1->celular                    = $request["celular" . $i];
					$obj1->fecha_nacimiento           = $request["fecha_nacimiento" . $i];
					$obj1->deleted_at                 = null;

					if ($obj1->save()):
						$obj2                 = new Derechoautor_integrante();
						$obj2->principal      = ($request["principal"] == "principal" . $i) ? true : false;
						$obj2->idderechoautor = $obj->id;
						$obj2->idpersona      = $obj1->id;
						$obj2->orden          = $i + 1;
						$obj2->deleted_at     = null;
						if ($obj2->save()):
							$index_principal = ($request["principal"] == "principal" . $i) ? $i : $index_principal;
						endif;
					endif;
				endfor;
				if ($index_principal === null) {
					throw ValidationException::withMessages(["required_principal" => "Es necesario seleccionar un representante principal."]);
				}
				$data          = [];
				$data["index"] = $index_principal;
				$data["fecha"] = $obj->fecha;
				$data["hora"]  = $obj->hora;
				return response()->json($data);
			endif;
		});
	}

	public function consultar(Request $request) {
		$token         = Crypt::decryptString($request->token);
		$tipodocumento = $request->tipodocumento;
		$nrodocumento  = $request->nrodocumento;

		if ($token !== $this->token):
			abort(403, 'Acceso denegado');
		endif;

		$consulta = Persona::select("persona.*")->with(["distrito_actual.provincia"])->where("persona.idtipopersona", 1)->where("persona.idtipo_documento_identidad", $tipodocumento)->where('persona.numero_documento_identidad', $nrodocumento)->first();

		if (is_null($consulta) AND mb_strlen($nrodocumento) == 8):

			$url   = "dni";
			$token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
			$curl  = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL            => "https://api.apis.net.pe/v1/" . $url . "?numero=" . $nrodocumento . "&" . $token,
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

			$data_reniec = json_decode($response, true);

			$data                    = [];
			$data["numeroDocumento"] = null;
			$data["apellidoPaterno"] = null;
			$data["apellidoMaterno"] = null;

			$data["distrito_actual"] = null;

			$data["fecha_nacimiento"] = null;
			$data["tipocalle"]        = null;
			$data["direccion"]        = null;
			$data["correo"]           = null;
			$data["celular"]          = null;
			$data["idsexo"]           = null;

			if (is_array($data_reniec)):
				$data["numeroDocumento"] = $data_reniec["numeroDocumento"];
				$data["apellidoPaterno"] = $data_reniec["apellidoPaterno"];
				$data["apellidoMaterno"] = $data_reniec["apellidoMaterno"];
				$data["nombres"]         = $data_reniec["nombres"];
			endif;
			return response()->json($data);
		else:
			$data                    = [];
			$data["numeroDocumento"] = $consulta->numero_documento_identidad;
			$data["apellidoPaterno"] = $consulta->apellido_paterno;
			$data["apellidoMaterno"] = $consulta->apellido_materno;
			$data["nombres"]         = $consulta->nombres;

			$data["distrito_actual"] = $consulta->distrito_actual;

			$data["fecha_nacimiento"] = $consulta->fecha_nacimiento;
			$data["tipocalle"]        = $consulta->tipocalle;
			$data["direccion"]        = $consulta->direccion;
			$data["correo"]           = $consulta->correo;
			$data["celular"]          = $consulta->celular;
			$data["idsexo"]           = $consulta->idsexo;

			return response()->json($data);
		endif;
	}
}
