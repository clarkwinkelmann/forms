<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFieldSubmissionTable extends Migration
{
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

    public function down()
    {
        Schema::dropIfExists('field_submission');
    }
}
