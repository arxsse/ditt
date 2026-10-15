<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaisTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('pais', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string('codigo_iso', 3)->unique();
			$table->string('descripcion', 240);
			$table->string('continente', 120)->nullable();
			$table->string('moneda', 120)->nullable();
			$table->string('idioma_oficial', 120)->nullable();
		});
	}

	public function down() {
		Schema::dropIfExists('pais');
	}
}
