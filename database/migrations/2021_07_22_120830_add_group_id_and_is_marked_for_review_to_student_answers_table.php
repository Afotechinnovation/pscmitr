<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdAndIsMarkedForReviewToStudentAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->integer('option_id')->nullable()->change();
            $table->integer('group_id')->after('test_id');
            $table->boolean('is_marked_for_review')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_answers', function (Blueprint $table) {
            $table->integer('option_id')->nullable()->change();
            $table->dropColumn('group_id');
            $table->dropColumn('is_marked_for_review');
        });
    }
}
