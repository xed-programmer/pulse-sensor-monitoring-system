<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpo2LimitToPulses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pulses', function (Blueprint $table) {
            $table->integer('spo2_limit')->default(90);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pulses', function (Blueprint $table) {
            $table->dropColumn('spo2_limit');
        });
    }
}
