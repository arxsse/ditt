<?php

use App\Http\Controllers\configuracion\CargoController;
use App\Http\Controllers\configuracion\EmpresaController;
use App\Http\Controllers\derechoautor\DerechoautorController;
use App\Http\Controllers\derechoautor\RequisitoController;
use App\Http\Controllers\derechoautor\TipoderechoautorController;
use App\Http\Controllers\Estado_civilController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\seguridad\AccesosController;
use App\Http\Controllers\seguridad\BotonController;
use App\Http\Controllers\seguridad\ModuloController;
use App\Http\Controllers\seguridad\RoleController;
use App\Http\Controllers\seguridad\UsuarioController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\Tipo_documentoController;
use App\Http\Controllers\Tipo_personaController;
use App\Http\Controllers\UbigeoController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', function () {return redirect()->route('login');});

Route::get('formulario', [FormularioController::class, 'index'])->name('formulario');
Route::post('formulario/store', [FormularioController::class, 'store'])->name('formulario.store');
Route::get('formulario/consultar', [FormularioController::class, 'consultar'])->name('formulario.consultar');

//------------------------------------------------------------------------------------ Ubigeo
Route::get('ubigeo/get_provincia/{iddepartamento}', [UbigeoController::class, 'get_provincia'])->name('ubigeo.get_provincia');
Route::get('ubigeo/get_distrito/{idprovincia}', [UbigeoController::class, 'get_distrito'])->name('ubigeo.get_distrito');

Route::group(["middleware" => ['auth']], function () {
	Route::get('/home', [HomeController::class, 'index'])->name('home');

//----------------------------------------------------------------------------------------------------->> START Derecho autor
	//------------------------------------------------------------------------------------ Tipo derecho autor
	Route::resource('tipoderechoautor', TipoderechoautorController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('tipoderechoautor/grilla', [TipoderechoautorController::class, 'grilla'])->name('tipoderechoautor.grilla');

	//------------------------------------------------------------------------------------ Tipo derecho autor
	Route::resource('requisito', RequisitoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('requisito/grilla', [RequisitoController::class, 'grilla'])->name('requisito.grilla');

	//------------------------------------------------------------------------------------ Derech oautor
	Route::resource('derechoautor', DerechoautorController::class)->only('index', 'store', 'edit', 'destroy');
	Route::get('derechoautor/grilla', [DerechoautorController::class, 'grilla'])->name('derechoautor.grilla');
	Route::get('derechoautor/{id}/proceso', [DerechoautorController::class, 'proceso'])->name('derechoautor.proceso');
	Route::post('derechoautor/store_proceso', [DerechoautorController::class, 'store_proceso'])->name('derechoautor.store_proceso');
	Route::get('derechoautor/{id}/show', [DerechoautorController::class, 'show'])->name('derechoautor.show');
	Route::get('derechoautor/formateria', [DerechoautorController::class, 'formateria'])->name('derechoautor.formateria');

//----------------------------------------------------------------------------------------------------->> END Derecho autor

//----------------------------------------------------------------------------------------------------->> START Configuracion
	//------------------------------------------------------------------------------------ Empresa
	Route::resource('empresa', EmpresaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('empresa/grilla', [EmpresaController::class, 'grilla'])->name('empresa.grilla');

	//------------------------------------------------------------------------------------ Tipo Persona
	Route::resource('tipopersona', Tipo_personaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('tipopersona/grilla', [Tipo_personaController::class, 'grilla'])->name('tipopersona.grilla');

	//------------------------------------------------------------------------------------ Tipo documento
	Route::resource('tipo_documento_identidad', Tipo_documentoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('tipo_documento_identidad/grilla', [Tipo_documentoController::class, 'grilla'])->name('tipo_documento_identidad.grilla');

	//------------------------------------------------------------------------------------ Estado Civil
	Route::resource('estado_civil', Estado_civilController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('estado_civil/grilla', [Estado_civilController::class, 'grilla'])->name('estado_civil.grilla');

	//------------------------------------------------------------------------------------ Sexo
	Route::resource('sexo', SexoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('sexo/grilla', [SexoController::class, 'grilla'])->name('sexo.grilla');

	//------------------------------------------------------------------------------------ Persona
	Route::resource('persona', PersonaController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('persona/grilla', [PersonaController::class, 'grilla'])->name('persona.grilla');
	Route::get('persona/consulta_sunat/{documento}', [PersonaController::class, 'consulta_sunat'])->name('persona.consulta_sunat');
	Route::get('persona/buscar/{search}/{tipo?}', [PersonaController::class, 'buscar'])->name('persona.buscar');

	//------------------------------------------------------------------------------------ Cargo
	Route::resource('cargo', CargoController::class)->only('index', 'create', 'store', 'edit', 'destroy');
	Route::get('cargo/grilla', [CargoController::class, 'grilla'])->name('cargo.grilla');
	Route::get('cargo/get_cargo', [CargoController::class, 'get_cargo'])->name('cargo.get_cargo');

//----------------------------------------------------------------------------------------------------->> END Configuracion

//----------------------------------------------------------------------------------------------------->> START Seguridad
	//------------------------------------------------------------------------------------ Boton
	Route::resource("boton", BotonController::class)->only("index", "create", "store", "edit", "destroy");
	Route::get("boton/grilla", [BotonController::class, "grilla"])->name("boton.grilla");
	Route::get('boton/get_boton', [BotonController::class, 'get_boton'])->name('boton.get_boton');

	//------------------------------------------------------------------------------------ Modulo
	Route::resource("modulo", ModuloController::class)->only("index", "create", "store", "edit", "destroy");
	Route::get("modulo/grilla", [ModuloController::class, "grilla"])->name("modulo.grilla");
	Route::get('modulo/get_modulopadre', [ModuloController::class, 'get_modulopadre'])->name('modulo.get_modulopadre');
	Route::get('modulo/get_padre', [ModuloController::class, 'get_padre'])->name('modulo.get_padre');

	//------------------------------------------------------------------------------------ Role
	Route::resource("role", RoleController::class)->only("index", "create", "store", "edit", "destroy");
	Route::get("role/grilla", [RoleController::class, "grilla"])->name("role.grilla");
	Route::get("role/get_role", [RoleController::class, "get_role"])->name("role.get_role");

	//------------------------------------------------------------------------------------ Usuario
	Route::resource("usuario", UsuarioController::class)->only("index", "create", "store", "edit", "destroy");
	Route::get("usuario/grilla", [UsuarioController::class, "grilla"])->name("usuario.grilla");
	Route::get('usuario/reset/{id}', [UsuarioController::class, 'reset'])->name('usuario.reset');
	Route::post('usuario/store_reset', [UsuarioController::class, 'store_reset'])->name('usuario.store_reset');

	//------------------------------------------------------------------------------------ Accesos
	Route::resource('accesos', AccesosController::class)->only("index", "store");
	Route::get('accesos/acceso', [AccesosController::class, 'acceso'])->name('accesos.acceso');
//----------------------------------------------------------------------------------------------------->> END Seguridad

});
