<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTestResultIdInTestRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_ratings', function (Blueprint $table) {
            $table->renameColumn('test_result_id','test_id');
            $table->renameColumn('package_test_id','package_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_ratings', function (Blueprint $table) {
            $table->renameColumn('test_id','test_result_id');
            $table->renameColumn('package_id','package_test_id');
        });
    }
}
