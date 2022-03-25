<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->integer('course_id')->after('name')->nullable();
            $table->integer('subject_id')->after('course_id')->nullable();
            $table->integer('chapter_id')->after('subject_id')->nullable();
            $table->dropColumn('package_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('course_id');
            $table->dropColumn('subject_id');
            $table->dropColumn('chapter_id');
            $table->integer('package_id')->after('id');
        });
    }
}
