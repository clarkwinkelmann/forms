<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSubmissionsAddSpamColumn extends Migration
{
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->boolean('is_spam')->default(0);
        });
    }

    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('is_spam');
        });
    }
}
