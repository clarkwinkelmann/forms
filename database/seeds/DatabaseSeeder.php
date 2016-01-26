<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(TestFormSeeder::class);
	}

}
