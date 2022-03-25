<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTestIdInTestRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_ratings', function (Blueprint $table) {
            $table->renameColumn('test_id','package_test_id');
            $table->integer('test_result_id')->after('test_id');
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
            $table->renameColumn('package_test_id','test_id');
            $table->dropColumn('test_result_id');
        });
    }
}
