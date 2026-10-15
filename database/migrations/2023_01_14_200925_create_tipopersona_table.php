<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipopersonaTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tipopersona', function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string("descripcion", 240);
			$table->string("codigo", 60);
		});
	}

	public function down() {
		Schema::dropIfExists('tipopersona');
	}
}
