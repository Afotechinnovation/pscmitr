<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('exam_category_id')->unsigned();
            $table->string('title');
            $table->longText('body');
            $table->date('last_date');
            $table->string('exam_number');
            $table->string('file')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_notifications');
    }
}
