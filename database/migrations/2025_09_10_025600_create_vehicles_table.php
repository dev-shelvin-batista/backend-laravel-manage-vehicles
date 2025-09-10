<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->unsignedInteger('user_id');
            $table->string('car_plate', 64);
            $table->integer('year');
            $table->unsignedInteger('setting_id');
            $table->unsignedInteger('body_car_id');
            $table->string('photo', 255);
            $table->timestamps();
        });
        Schema::table('vehicles', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('vehicles', function($table) {
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
        });
        Schema::table('vehicles', function($table) {
            $table->foreign('body_car_id')->references('id')->on('body_car')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
