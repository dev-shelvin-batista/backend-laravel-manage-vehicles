<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 128);
            $table->string('last_name', 128);
            $table->string('type_documentation', 10);
            $table->string('documentation', 64);
            $table->string('phone_number', 15);
            $table->string('email', 100);
            $table->string('password', 200);
            $table->string('address', 255)->nullable();
            $table->string('photo_documentation_a', 255)->nullable();
            $table->string('photo_documentation_b', 255)->nullable();
            $table->unsignedInteger('status_id');
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
