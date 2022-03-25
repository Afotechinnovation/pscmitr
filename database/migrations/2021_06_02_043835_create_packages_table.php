<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id');
            $table->integer('subject_id')->nullable();
            $table->integer('chapter_id')->nullable();
            $table->string('name');
            $table->string('image');
            $table->string('display_name');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->double('price');
            $table->double('offer_price')->nullable();
            $table->longText('package_content')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('status')->default('enabled')->comment('enabled','disabled');
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
        Schema::dropIfExists('packages');
    }
}
