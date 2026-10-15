<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesosTable extends Migration {
	public function up() {
		Schema::create("seguridad.accesos", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");

			$table->unsignedBigInteger("idmodulo");
			$table->foreign("idmodulo")->references("id")->on("seguridad.modulo");
			$table->unsignedBigInteger("idrole");
			$table->foreign("idrole")->references("id")->on("seguridad.role");
		});
	}
	public function down() {
		Schema::dropIfExists("seguridad.accesos");
	}
}
