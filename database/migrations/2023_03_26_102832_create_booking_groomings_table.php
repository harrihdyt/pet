<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingGroomingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_groomings', function (Blueprint $table) {
            $table->id();
            $table->string('code_booking');
            $table->string('pets_name');
            $table->string('pets_type');
            $table->string('service_type');
            $table->string('service_category');
            $table->string('pets_weight');
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
        Schema::dropIfExists('booking_groomings');
    }
}
