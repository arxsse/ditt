<?php

use App\Actions\PGSchema;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaSeguridad extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		(new PGSchema)->create("seguridad");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		(new PGSchema)->drop("seguridad");
	}
}
