<?php

use App\Actions\PGSchema;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaDerechoautor extends Migration {

	public function up() {
		(new PGSchema)->create("derechoautor");
	}

	public function down() {
		(new PGSchema)->drop("derechoautor");
	}
}
