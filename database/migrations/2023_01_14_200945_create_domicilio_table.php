<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomicilioTable extends Migration {
	public function up() {
		Schema::create("domicilio", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->string("descripcion", 240);
			$table->string("abreviatura", 60)->nullable();
		});
	}
	public function down() {
		Schema::dropIfExists("domicilio");
	}
}
