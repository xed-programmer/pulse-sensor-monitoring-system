<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePulsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pulses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained();
            $table->foreignId('patient_id')->constrained();
            $table->integer('hr');
            $table->integer('spo2');
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
        Schema::dropIfExists('pulses');
    }
}
