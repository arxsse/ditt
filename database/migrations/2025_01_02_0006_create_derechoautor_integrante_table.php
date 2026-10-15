<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerechoautorIntegranteTable extends Migration {
	public function up() {
		Schema::create("derechoautor.derechoautor_integrante", function (Blueprint $table) {
			$table->id();
			$table->softDeletes();
			$table->timestamps();

			$table->boolean("principal")->default(false);
			$table->unsignedBigInteger("idderechoautor");
			$table->foreign("idderechoautor")->references("id")->on("derechoautor.derechoautor");
			$table->unsignedBigInteger("idpersona");
			$table->foreign("idpersona")->references("id")->on("persona");
			$table->integer("orden")->default(1);
		});
	}
	public function down() {
		Schema::dropIfExists("derechoautor.derechoautor_integrante");
	}
}
