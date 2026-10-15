<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerechoautorTable extends Migration {
	public function up() {
		Schema::create('derechoautor.derechoautor', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");
			$table->unsignedBigInteger("idempresa");
			$table->foreign("idempresa")->references("id")->on("configuracion.empresa");

			$table->unsignedBigInteger("idtipoderechoautor");
			$table->foreign("idtipoderechoautor")->references("id")->on("derechoautor.tipoderechoautor");
			$table->unsignedBigInteger("idproceso");
			$table->foreign("idproceso")->references("id")->on("derechoautor.proceso");

			$table->string("nrocargo", 120)->nullable();
			$table->string("nroexpediente", 120)->nullable();
			$table->text("urlcodigofuente")->nullable()->comment(" Url del codigo de fuente, cuando es Derecho de Software");
			$table->string("titulo", 240);
			$table->date("fecha")->nullable();
			$table->time("hora")->nullable();
			$table->date("fecha_proceso")->nullable();
			$table->time("hora_proceso")->nullable();
			$table->text("urlresolucion")->nullable();
			$table->text("observacion")->nullable();
		});
	}

	public function down() {
		Schema::dropIfExists('derechoautor.derechoautor');
	}
}
