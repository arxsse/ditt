<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBotonModuloTable extends Migration {
	public function up() {
		Schema::create("seguridad.boton_modulo", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idmodulo");
			$table->foreign("idmodulo")->references("id")->on("seguridad.modulo");
			$table->unsignedBigInteger("idboton");
			$table->foreign("idboton")->references("id")->on("seguridad.boton");
		});
	}
	public function down() {
		Schema::dropIfExists("seguridad.boton_modulo");
	}
}
