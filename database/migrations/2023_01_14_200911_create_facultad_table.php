<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultadTable extends Migration {
	public function up() {
		Schema::create('configuracion.facultad', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string("descripcion", 240);
			$table->string("abreviatura", 120);
			$table->integer("orden")->default(1);

		});
	}

	public function down() {
		Schema::dropIfExists('configuracion.facultad');
	}
}
