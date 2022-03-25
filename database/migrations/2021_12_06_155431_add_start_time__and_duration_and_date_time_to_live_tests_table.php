<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeAndDurationAndDateTimeToLiveTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_tests', function (Blueprint $table) {
            $table->dateTime('date_time')->after('test_id');
            $table->time('duration')->after('test_id');
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
        Schema::table('live_tests', function (Blueprint $table) {
            //
        });
    }
}
