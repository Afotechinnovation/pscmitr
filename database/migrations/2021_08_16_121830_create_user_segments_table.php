<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_segments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age_from')->nullable();
            $table->integer('age_to')->nullable();
            $table->boolean('gender_male')->nullable();
            $table->boolean('gender_female')->nullable();
            $table->boolean('marks_less_than')->nullable();
            $table->boolean('marks_greater_than')->nullable();
            $table->boolean('marks_is_equal')->nullable();
            $table->boolean('marks_in_between')->nullable();
            $table->integer('marks')->nullable();
            $table->string('language')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('name_contains')->nullable();
            $table->integer('subscription')->nullable();
            $table->integer('student_selected_course_id')->nullable();
            $table->integer('student_not_selected_course_id')->nullable();
            $table->integer('student_written_test_id')->nullable();
            $table->integer('student_not_written_test_id')->nullable();
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
        Schema::dropIfExists('user_segments');
    }
}
