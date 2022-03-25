<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestResultIdToMarkForReviewQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mark_for_review_questions', function (Blueprint $table) {
            $table->integer('test_result_id')->after('package_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mark_for_review_questions', function (Blueprint $table) {
            $table->dropColumn('test_result_id')->after('package_id');
        });
    }
}
