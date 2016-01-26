<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldSubmissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('field_submission', function (Blueprint $table) {
			$table->integer('field_id')->unsigned();
			$table->integer('submission_id')->unsigned()->index();
			$table->text('value');
			$table->timestamps();

			$table->primary(['field_id', 'submission_id']);

			$table->foreign('field_id')->references('id')->on('fields')->onDelete('cascade');
			$table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('field_submission');
	}

}
