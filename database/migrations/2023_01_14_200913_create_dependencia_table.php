<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependenciaTable extends Migration {

	public function up() {
		Schema::create('configuracion.dependencia', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger('idfacultad');
			$table->foreign('idfacultad')->references('id')->on('configuracion.facultad');
			$table->string("codigo", 60)->comment("E1 --> Escuela || D1 --> Departamento");
			$table->string("descripcion", 240);
			$table->string("abreviatura", 120)->nullable();
			$table->integer("orden")->default(1);
		});
	}

	public function down() {
		Schema::dropIfExists('configuracion.dependencia');
	}
}
