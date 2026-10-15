<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbdistritoTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ubdistrito', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger("idpais");
			$table->foreign("idpais")->references("id")->on("pais");

			$table->unsignedBigInteger('idprovincia');
			$table->foreign('idprovincia')->references('id')->on('ubprovincia');
			$table->string('ubigeo', 10);
			$table->string('descripcion', 240);
		});
	}

	public function down() {
		Schema::dropIfExists('ubdistrito');
	}
}
