<?php

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('forms', function (Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->string('title')->index();
			$table->boolean('accept_submissions')->default(true)->index();
			$table->string('send_email_to')->nullable()->default(null);
			$table->text('confirmation_message')->nullable();
			$table->string('confirmation_email_field')->nullable()->default(null);
			$table->string('redirect_to_url')->nullable()->default(null);
			$table->string('owner_email')->nullable()->default(null);
			$table->string('owner_name')->nullable()->default(null);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('forms');
	}

}
