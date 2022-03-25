<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibilityAndAvailabitilityToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->date('visible_from_date')->after('offer_price');
            $table->date('visible_to_date')->after('visible_from_date');
            $table->integer('availability')->after('visible_to_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('visible_from_date');
            $table->dropColumn('visible_to_date');
            $table->dropColumn('availability');
        });
    }
}
