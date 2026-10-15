<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloTable extends Migration {
	public function up() {
		Schema::create("seguridad.modulo", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");

			$table->integer("idpadre")->nullable();
			$table->string("descripcion", 240);
			$table->string("abreviatura", 120)->nullable();
			$table->text("url")->nullable();
			$table->integer("orden")->default(1);
			$table->string("icono", 60)->nullable();
			$table->boolean("accesos_directo")->default(false);
		});
	}
	public function down() {
		Schema::dropIfExists("seguridad.modulo");
	}
}
