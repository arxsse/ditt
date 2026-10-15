<?php

namespace Database\Seeders;

use Database\Seeders\modulos\A_GeneralSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	public function run() {
		$this->call(A_GeneralSeeder::class);
	}
}
