<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedevents', function (Blueprint $table) {
            $table->id();
            $table->text('eventname');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('collegeID');
            $table->integer('eventcolor');
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
        Schema::dropIfExists('schedevents');
    }
};
