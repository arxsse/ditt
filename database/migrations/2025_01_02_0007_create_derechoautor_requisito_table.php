<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerechoautorRequisitoTable extends Migration {

	public function up() {
		Schema::create("derechoautor.derechoautor_requisito", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idderechoautor");
			$table->foreign("idderechoautor")->references("id")->on("derechoautor.derechoautor");
			$table->string("descripcion", 240);
			$table->string('rutadocumento');
			$table->string("sizedocumento")->nullable();
			$table->integer("orden")->default(1);
		});
	}
	public function down() {
		Schema::dropIfExists("derechoautor.derechoautor_requisito");
	}
}
