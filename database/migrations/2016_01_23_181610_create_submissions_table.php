<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('submissions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('form_id')->unsigned()->index();
			$table->string('user_ip')->index();
			$table->string('user_agent')->index();
			$table->string('user_referer')->nullable()->index();
			$table->timestamps();

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
		Schema::drop('submissions');
	}

}
