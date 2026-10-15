<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration {
	public function up() {
		Schema::create("persona", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");
			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");
			$table->unsignedBigInteger('idfacultad')->nullable();
			$table->foreign('idfacultad')->references('id')->on('configuracion.facultad');
			$table->unsignedBigInteger('idoficina')->nullable();
			$table->foreign('idoficina')->references('id')->on('configuracion.oficina');

			$table->unsignedBigInteger("idtipopersona")->default(1);
			$table->foreign("idtipopersona")->references("id")->on("tipopersona");
			$table->unsignedBigInteger("idtipo_documento_identidad");
			$table->foreign("idtipo_documento_identidad")->references("id")->on("tipo_documento_identidad");
			$table->string("numero_documento_identidad", 16);

			$table->unsignedBigInteger('ubigeo_procedencia')->nullable();
			$table->foreign('ubigeo_procedencia')->references('id')->on('ubdistrito');
			$table->unsignedBigInteger('ubigeo_actual')->nullable();
			$table->foreign('ubigeo_actual')->references('id')->on('ubdistrito');

			$table->unsignedBigInteger("idsexo")->nullable();
			$table->foreign("idsexo")->references("id")->on("sexo");
			$table->unsignedBigInteger("idestado_civil")->nullable();
			$table->foreign("idestado_civil")->references("id")->on("estado_civil");
			$table->unsignedBigInteger("iddomicilio")->nullable();
			$table->foreign("iddomicilio")->references("id")->on("domicilio");

			$table->string("nombres", 240);
			$table->string("apellido_paterno", 120);
			$table->string("apellido_materno", 120);
			$table->text("nombre_completo");
			$table->string("rutaimagen")->nullable();
			$table->string("sizeimagen")->nullable();
			$table->text("correo")->nullable();
			$table->text("direccion")->nullable();
			$table->string("celular", 13)->nullable();
			$table->date("fecha_nacimiento")->nullable();
			$table->boolean("representante")->default(false);
		});
	}
	public function down() {
		Schema::dropIfExists("persona");
	}
}
