<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('form_id')->unsigned()->index();
			$table->string('slug')->index();
			$table->string('title')->index();
			$table->string('rules');
			$table->timestamps();

			$table->unique(['form_id', 'slug']);

			$table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fields');
	}

}
