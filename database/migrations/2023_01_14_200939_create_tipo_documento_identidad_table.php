<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoDocumentoIdentidadTable extends Migration {
	public function up() {
		Schema::create("tipo_documento_identidad", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string("descripcion", 240);
			$table->string("abreviatura", 60)->nullable();
			$table->integer("rango");
		});
	}
	public function down() {
		Schema::dropIfExists("tipo_documento_identidad");
	}
}
