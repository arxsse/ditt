<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbprovinciaTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ubprovincia', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");

			$table->unsignedBigInteger('iddepartamento');
			$table->foreign('iddepartamento')->references('id')->on('ubdepartamento');
			$table->string('ubigeo', 10);
			$table->string('descripcion', 240);
		});
	}

	public function down() {
		Schema::dropIfExists('ubprovincia');
	}
}
