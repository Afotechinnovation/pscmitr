<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseIdAndSubjectIdAndChapterIdToQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('course_id')->after('question')->unsigned();
            $table->integer('subject_id')->after('question')->unsigned();
            $table->integer('chapter_id')->after('question')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('course_id')->after('question')->unsigned();
            $table->dropColumn('subject_id')->after('question')->unsigned();
            $table->dropColumn('chapter_id')->after('question')->unsigned();
        });
    }
}
