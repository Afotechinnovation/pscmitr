<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarkToToUserSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_segments', function (Blueprint $table) {
            $table->integer('mark_to')->nullable()->after('marks_in_between');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_segments', function (Blueprint $table) {
            $table->dropColumn('mark_to')->nullable()->after('marks_in_between');
        });
    }
}
