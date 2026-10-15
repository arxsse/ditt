<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoderechoautorTable extends Migration {
	public function up() {
		Schema::create('derechoautor.tipoderechoautor', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");
			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");

			$table->string("categoria", 1)->default("1")->comment("1 --> Derecho de Autor | 2 --> Patente");
			$table->string("icono", 120)->nullable();
			$table->string("descripcion", 240);
			$table->text("resumen");
			$table->integer("orden")->default(1);
		});
	}

	public function down() {
		Schema::dropIfExists('derechoautor.tipoderechoautor');
	}
}
