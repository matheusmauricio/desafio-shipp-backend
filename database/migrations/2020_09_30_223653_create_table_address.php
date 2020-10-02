<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('county');
            $table->string('street_number');
            $table->string('street_name');
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('square_footage');
            $table->string('location');
            $table->float('latitude');
            $table->float('longitude');
            $table->boolean('needs_recoding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
