<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByAndDisplayNameAndDateTimeToTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dateTime('date_time')->after('negative_marks')->nullable();
            $table->string('display_name')->after('date_time');
            $table->string('created_by')->after('display_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('date_time');
            $table->dropColumn('display_name');
            $table->dropColumn('created_by');
        });
    }
}
