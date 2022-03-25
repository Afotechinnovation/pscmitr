<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkForReviewQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_for_review_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id')->unsigned();
            $table->integer('package_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('mark_for_review_questions');
    }
}
