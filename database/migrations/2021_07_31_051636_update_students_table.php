<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->date('date_of_birth')->after('pin_code');
            $table->string('gender')->after('pin_code');
            $table->integer('country_id')->after('pin_code')->unsigned();
            $table->integer('state_id')->after('pin_code')->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('date_of_birth')->after('pin_code');
            $table->dropColumn('gender')->after('pin_code');
            $table->dropColumn('country_id')->after('pin_code')->unsigned();
            $table->dropColumn('state_id')->after('pin_code')->unsigned();

        });

    }
}
