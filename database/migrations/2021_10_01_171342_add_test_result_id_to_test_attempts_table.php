<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestResultIdToTestAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->integer('test_result_id')->after('package_id')->unsigned();
          //  $table->integer('test_result_id')->after('package_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_attempts', function (Blueprint $table) {
            $table->dropColumn('test_result_id')->after('package_id');
        });
    }
}
