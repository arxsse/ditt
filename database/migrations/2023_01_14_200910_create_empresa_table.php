<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration {

	public function up() {
		Schema::create("configuracion.empresa", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");

			$table->string("ruc", 11)->unique();
			$table->text("razonsocial");
			$table->string("abreviatura", 60);
			$table->text("oficina", 60);
			$table->string("abreviatura_oficina", 60);
			$table->unsignedBigInteger('ubigeo')->nullable();
			$table->foreign('ubigeo')->references('id')->on('ubdistrito');
			$table->text("direccion");
			$table->string("celular", 13)->nullable();
			$table->string("rutaimagen")->nullable();
			$table->string("sizeimagen")->nullable();
		});
	}
	public function down() {
		Schema::dropIfExists("configuracion.empresa");
	}
}
