<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectIdAndCourseIdToUserDoubtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_doubts', function (Blueprint $table) {
            $table->integer('subject_id')->after('question_id');
            $table->integer('course_id')->after('question_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_doubts', function (Blueprint $table) {
            $table->dropColumn('subject_id')->after('question_id');
            $table->dropColumn('course_id')->after('question_id');
        });
    }
}
