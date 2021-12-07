<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTimeTz('start');
            $table->dateTimeTz('end');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
