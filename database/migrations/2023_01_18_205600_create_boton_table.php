<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotonTable extends Migration {
	public function up() {
		Schema::create("seguridad.boton", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");

			$table->string("descripcion", 240);
			$table->string("funcion", 120);
			$table->string("clase", 120)->nullable();
			$table->string("icono", 60)->nullable();
			$table->integer("orden")->nullable()->default(1);
			$table->boolean("mostrar")->default(false);
			$table->boolean("es_boton")->default(false);
		});
	}
	public function down() {
		Schema::dropIfExists("seguridad.boton");
	}
}
