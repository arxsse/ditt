<?php

use App\Actions\PGSchema;
use Illuminate\Database\Migrations\Migration;

class CreateSchemaConfiguracion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		(new PGSchema)->create("configuracion");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		(new PGSchema)->drop("configuracion");
	}
}
