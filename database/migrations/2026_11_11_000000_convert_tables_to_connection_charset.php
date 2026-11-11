<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertTablesToConnectionCharset extends Migration
{
    public function up()
    {
        // only MySQL and MariaDB store a character set per table
        if (!in_array(DB::getDriverName(), ['mysql', 'mariadb'])) {
            return;
        }

        // databases created before Laravel 5.4 use the 3-byte utf8mb3, which can't store characters such as emojis
        $charset = DB::connection()->getConfig('charset');
        $collation = DB::connection()->getConfig('collation');

        foreach (['users', 'forms', 'fields', 'submissions', 'field_submission'] as $table) {
            DB::statement("ALTER TABLE `$table` CONVERT TO CHARACTER SET $charset COLLATE $collation");
        }
    }
}
