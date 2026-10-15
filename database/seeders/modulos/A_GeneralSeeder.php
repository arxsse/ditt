<?php
namespace Database\Seeders\modulos;

use App\Models\configuracion\Empresa;
use App\Models\derechoautor\Proceso;
use App\Models\derechoautor\Tipoderechoautor;
use App\Models\derechoautor\Tipoderechoautor_requisitos;
use App\Models\Domicilio;
use App\Models\Estado_civil;
use App\Models\Pais;
use App\Models\Persona;
use App\Models\seguridad\User;
use App\Models\Sexo;
use App\Models\Tipopersona;
use App\Models\Tipo_documento_identidad;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class A_GeneralSeeder extends Seeder {

	public function run() {

		//------------------------------------------------------- Pais
		$data              = new Pais();
		$data->codigo_iso  = 'PER';
		$data->descripcion = 'Perú';
		$data->save();

		//------------------------------------------------------- Tipo persona
		$data              = new Tipopersona();
		$data->descripcion = 'Autor';
		$data->codigo      = 'AU';
		$data->save();

		$data              = new Tipopersona();
		$data->descripcion = 'Administrativo';
		$data->codigo      = 'AD';
		$data->save();

		$data              = new Tipopersona();
		$data->descripcion = 'Administrativo y Autor';
		$data->codigo      = 'AD_AU';
		$data->save();

		//------------------------------------------------------- Tipo_documento_identidad
		$data              = new Tipo_documento_identidad();
		$data->descripcion = 'Documento Nacional de Identidad';
		$data->abreviatura = 'DNI';
		$data->rango       = 8;
		$data->save();

		//------------------------------------------------------- Estado_civil
		$data              = new Estado_civil();
		$data->descripcion = 'Soltero(a)';
		$data->save();

		$data              = new Estado_civil();
		$data->descripcion = 'Casado(a)';
		$data->save();

		$data              = new Estado_civil();
		$data->descripcion = 'Viudo(a)';
		$data->save();

		$data              = new Estado_civil();
		$data->descripcion = 'Divorciado(a)';
		$data->save();

		//------------------------------------------------------- Sexo
		$data              = new Sexo();
		$data->descripcion = 'Masculino';
		$data->abreviatura = 'M';
		$data->save();

		$data              = new Sexo();
		$data->descripcion = 'Femenino';
		$data->abreviatura = 'F';
		$data->save();

		//------------------------------------------------------- Domicilio
		$data              = new Domicilio();
		$data->descripcion = 'Calle';
		$data->abreviatura = 'Call.';
		$data->save();

		$data              = new Domicilio();
		$data->descripcion = 'Jirón';
		$data->abreviatura = 'Jir.';
		$data->save();

		$data              = new Domicilio();
		$data->descripcion = 'Avenida';
		$data->abreviatura = 'Ave.';
		$data->save();

		$matriz = [];
		//------------------------------------------------------- Empresa
		$data                      = new Empresa();
		$data->idpais              = 1;
		$data->ruc                 = '20160766191';
		$data->razonsocial         = 'UNIVERSIDAD NACIONAL DE SAN MARTIN';
		$data->abreviatura         = "UNSM";
		$data->oficina             = 'Dirección de Innovación y Transferencia Tecnológica';
		$data->abreviatura_oficina = 'DITT';
		$data->direccion           = 'Desconocido';
		$data->rutaimagen          = "logo.png";
		$data->sizeimagen          = "4315";
		$data->save();
		$matriz["empresa"][0]["id"] = $data->id;

		if (env("APP_LOCAL") == "true"):
			//------------------------------------------------------- Ubigeo PERU
			DB::statement("COPY ubdepartamento(idpais, ubigeo, descripcion) FROM '/home/colala/Escritorio/2025/DITT/UBIGEO/PERU/departamento.csv' DELIMITER ',' CSV HEADER;");
			DB::statement("COPY ubprovincia(idpais, iddepartamento, ubigeo, descripcion) FROM '/home/colala/Escritorio/2025/DITT/UBIGEO/PERU/provincia.csv' DELIMITER ',' CSV HEADER;");
			DB::statement("COPY ubdistrito(idpais, idprovincia, ubigeo, descripcion) FROM '/home/colala/Escritorio/2025/DITT/UBIGEO/PERU/distrito.csv' DELIMITER ',' CSV HEADER;");

			//------------------------------------------------------- Facultad
			DB::statement("COPY configuracion.facultad(descripcion, abreviatura, orden) FROM '/home/colala/Escritorio/2025/DITT/FACULTAD/facultad.csv' DELIMITER ',' CSV HEADER;");

			//------------------------------------------------------- Oficina
			DB::statement("COPY configuracion.oficina(descripcion, abreviatura, orden) FROM '/home/colala/Escritorio/2025/DITT/OFICINA/oficina.csv' DELIMITER ',' CSV HEADER;");
		endif;

		//------------------------------------------------------- Persona
		$data                             = new Persona();
		$data->idpais                     = 1;
		$data->idempresa                  = 1;
		$data->idtipopersona              = 2;
		$data->idsexo                     = 1;
		$data->iddomicilio                = 2;
		$data->idtipo_documento_identidad = 1;
		$data->numero_documento_identidad = "00000001";
		$data->nombres                    = "Administrador";
		$data->apellido_paterno           = "Desconocido";
		$data->apellido_materno           = "Desconocido";
		$data->nombre_completo            = "Administrador Desconocido Desconocido";
		$data->correo                     = "Administrador@gmail.com";
		$data->direccion                  = "Perú";
		$data->celular                    = "000000000";
		$data->fecha_nacimiento           = "01-01-2025";
		$data->save();

		$data                             = new Persona();
		$data->idpais                     = 1;
		$data->idempresa                  = 1;
		$data->idfacultad                 = 1;
		$data->idtipopersona              = 1;
		$data->idsexo                     = 1;
		$data->iddomicilio                = 2;
		$data->idtipo_documento_identidad = 1;
		$data->numero_documento_identidad = "71885613";
		$data->nombres                    = "Juan Carlos";
		$data->apellido_paterno           = "Colala";
		$data->apellido_materno           = "Sandoval";
		$data->nombre_completo            = "Juan Carlos Colala Sandoval";
		$data->correo                     = "colala@gmail.com";
		$data->direccion                  = "Lamas";
		$data->celular                    = "123456789";
		$data->fecha_nacimiento           = "01-01-1998";
		$data->save();

		$data                             = new Persona();
		$data->idpais                     = 1;
		$data->idempresa                  = 1;
		$data->idoficina                  = 20;
		$data->idtipopersona              = 2;
		$data->idsexo                     = 1;
		$data->iddomicilio                = 2;
		$data->idtipo_documento_identidad = 1;
		$data->numero_documento_identidad = "10063522";
		$data->nombres                    = "Gustavo";
		$data->apellido_paterno           = "Rios";
		$data->apellido_materno           = "Panduro";
		$data->nombre_completo            = "Gustavo Rios Panduro";
		$data->correo                     = "gustavo@gmail.com";
		$data->direccion                  = "Lamas";
		$data->celular                    = "932646231";
		$data->fecha_nacimiento           = "01-01-1998";
		$data->representante              = true;
		$data->save();

		//------------------------------------------------------- Role
		$rol_adm       = Role::create(['idempresa' => 1, 'name' => 'Super administrador']);
		$matriz["rol"] = $rol_adm->id;

		foreach ($matriz["empresa"] as $key => $value) {
			$rol = Role::create(['idempresa' => $value["id"], 'name' => 'Administrador ']);
		}

		//------------------------------------------------------- Usuario
		$user              = new User();
		$user->idpersona   = 1;
		$user->idrole      = 1;
		$user->usuario     = "ditt";
		$user->password    = Hash::make("ditt.2025@");
		$user->super_admin = true;
		$user->save();
		$user->assignRole($rol_adm->id);

		//------------------------------------------------------- Tipo derechoautor
		$datap              = new Tipoderechoautor();
		$datap->idpais      = 1;
		$datap->idempresa   = 1;
		$datap->categoria   = "1";
		$datap->icono       = "ti ti-brand-android";
		$datap->descripcion = "Registro de Autor de Software";
		$datap->resumen     = "El derecho de autor de software protege los programas de computadora como obras intelectuales, igual que un libro, una canción o una película. No se protege la idea en sí, sino la forma en que está expresada, es decir, el código fuente y el código objeto.";
		$datap->save();

		//------------------------------------------------------- Tipo derecho autor requisitos
		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Manual de Usuario.pdf";
		$data->urlejemplo         = "https://drive.google.com/file/d/1xo0a5kkLAiRH4Gx8ONhld1aiTlS7NUYF/view?usp=sharing";
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Memoria Descriptiva.pdf";
		$data->urlejemplo         = "https://drive.google.com/file/d/1yNBH1UnLRSK9l6WlsVsZiJIaL-dLcNGW/view?usp=sharing";
		$data->orden              = 2;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Cesión de Derechos Patrimoniales.pdf";
		$data->urlejemplo         = "https://drive.google.com/file/d/1Rbu40c2-S-jhrNbYSRoGqTxaPGmskH2i/view?usp=sharing";
		$data->orden              = 3;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 1";
		$data->urlejemplo         = "1";
		$data->seenvia            = false;
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 2";
		$data->urlejemplo         = "2";
		$data->seenvia            = false;
		$data->orden              = 2;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 3";
		$data->urlejemplo         = "3";
		$data->seenvia            = false;
		$data->orden              = 3;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 4";
		$data->urlejemplo         = "4";
		$data->seenvia            = false;
		$data->orden              = 4;
		$data->save();

		//------------------------------------------------------- Tipo derechoautor
		$datap              = new Tipoderechoautor();
		$datap->idpais      = 1;
		$datap->idempresa   = 1;
		$datap->categoria   = "1";
		$datap->icono       = "ti ti-book";
		$datap->descripcion = "Registro de Libros";
		$datap->resumen     = "El derecho de autor de libros protege a los escritores por la creación de obras originales escritas, como novelas, cuentos, ensayos, poemas, tesis, y textos académicos.";
		$datap->orden       = 2;
		$datap->save();

		//------------------------------------------------------- Tipo derecho autor requisitos
		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Libro.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Cesión de Derechos Patrimoniales.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 2;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 1";
		$data->urlejemplo         = "1";
		$data->seenvia            = false;
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 2";
		$data->urlejemplo         = "2";
		$data->seenvia            = false;
		$data->orden              = 2;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Formato Nro. 3";
		$data->urlejemplo         = "3";
		$data->seenvia            = false;
		$data->orden              = 3;
		$data->save();

		//------------------------------------------------------- Tipo derechoautor
		$datap              = new Tipoderechoautor();
		$datap->idpais      = 1;
		$datap->idempresa   = 1;
		$datap->categoria   = "2";
		$datap->icono       = "ti ti-virus";
		$datap->descripcion = "Diseño de Invención";
		$datap->resumen     = "Una patente de invención es un derecho exclusivo que se otorga a una persona o empresa para explotar una invención durante un tiempo limitado, a cambio de hacerla pública.";
		$datap->orden       = 3;
		$datap->save();

		//------------------------------------------------------- Tipo derecho autor requisitos
		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Documento tecnico.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Cesión de Derechos Patrimoniales.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 2;
		$data->save();

		//------------------------------------------------------- Tipo derechoautor
		$datap              = new Tipoderechoautor();
		$datap->idpais      = 1;
		$datap->idempresa   = 1;
		$datap->categoria   = "2";
		$datap->icono       = "ti ti-barcode";
		$datap->descripcion = "Diseño de Modelo de Utilidad";
		$datap->resumen     = "Un modelo de utilidad es una forma de protección legal para mejoras funcionales menores en productos ya existentes. Se le conoce también como “patente menor” o “invención pequeña”.";
		$datap->orden       = 4;
		$datap->save();

		//------------------------------------------------------- Tipo derecho autor requisitos
		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Documento tecnico.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Cesión de Derechos Patrimoniales.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 2;
		$data->save();

		//------------------------------------------------------- Tipo derechoautor
		$datap              = new Tipoderechoautor();
		$datap->idpais      = 1;
		$datap->idempresa   = 1;
		$datap->categoria   = "2";
		$datap->icono       = "ti ti-building-factory";
		$datap->descripcion = "Diseño Industrial";
		$datap->resumen     = "La patente industrial es un derecho exclusivo otorgado por el Estado para proteger una invención técnica: un producto o proceso nuevo, con utilidad industrial y actividad inventiva.";
		$datap->orden       = 5;
		$datap->save();

		//------------------------------------------------------- Tipo derecho autor requisitos
		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Documento tecnico.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 1;
		$data->save();

		$data                     = new Tipoderechoautor_requisitos();
		$data->idtipoderechoautor = $datap->id;
		$data->descripcion        = "Cesión de Derechos Patrimoniales.pdf";
		$data->urlejemplo         = "";
		$data->orden              = 2;
		$data->save();

		//------------------------------------------------------- Proceso
		$data_proceso    = [];
		$data_proceso[1] = ["Pendiente", "bg-label-dark"];
		$data_proceso[2] = ["Observado DITT", "bg-warning"];
		$data_proceso[3] = ["Obervado INDECOPI", "bg-warning"];
		$data_proceso[4] = ["Enviado INDECOPI", "bg-info"];
		$data_proceso[5] = ["Con resolucion", "bg-success"];
		$data_proceso[6] = ["Anulado", "bg-danger"];
		foreach ($data_proceso as $key => $value):
			$data              = new Proceso();
			$data->descripcion = $value[0];
			$data->clase       = $value[1];
			$data->orden       = $key + 1;
			$data->save();
		endforeach;

		$this->call(B1_BotonSeeder::class, false, compact('matriz'));

	}
}
