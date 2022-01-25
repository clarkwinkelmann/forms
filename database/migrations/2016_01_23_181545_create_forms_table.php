<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
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

    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
