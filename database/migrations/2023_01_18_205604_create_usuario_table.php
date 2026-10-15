<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration {
	public function up() {
		Schema::create("seguridad.usuario", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idpersona");
			$table->foreign("idpersona")->references("id")->on("persona");
			$table->unsignedBigInteger("idrole")->nullable();
			$table->foreign('idrole')->references('id')->on('seguridad.role');
			$table->string("usuario", 120);
			$table->string("password");
			$table->boolean("super_admin")->default(false);
			$table->rememberToken();
		});
	}
	public function down() {
		Schema::dropIfExists("seguridad.usuario");
	}
}
