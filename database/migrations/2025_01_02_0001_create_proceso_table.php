<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoTable extends Migration {
	public function up() {
		Schema::create("derechoautor.proceso", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string("descripcion", 240);
			$table->string("clase", 120)->nullable();
			$table->integer("orden")->default(1);
		});
	}
	public function down() {
		Schema::dropIfExists("derechoautor.proceso");
	}
}
