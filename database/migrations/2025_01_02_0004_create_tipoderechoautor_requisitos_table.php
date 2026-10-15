<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoderechoautorRequisitosTable extends Migration {
	public function up() {
		Schema::create("derechoautor.tipoderechoautor_requisitos", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->unsignedBigInteger("idtipoderechoautor");
			$table->foreign("idtipoderechoautor")->references("id")->on("derechoautor.tipoderechoautor");

			$table->string("descripcion", 240);
			$table->text("urlejemplo");
			$table->boolean("seenvia")->default(true);
			$table->integer("orden")->default(1);
		});
	}
	public function down() {
		Schema::dropIfExists("derechoautor.tipoderechoautor_requisitos");
	}
}
