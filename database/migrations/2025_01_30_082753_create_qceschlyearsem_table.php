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
        Schema::create('qceschlyearsem', function (Blueprint $table) {
            $table->id();
            $table->string('qceschlyear')->nullable();
            $table->string('qcesemester')->nullable();
            $table->string('qceratingfrom')->nullable();
            $table->string('qceratingto')->nullable();
            $table->enum('qcesemstat', ['1', '2', '3', '4'])->default('1');
            $table->integer('postedBy')->nullable();
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
        Schema::dropIfExists('qceschlyearsem');
    }
};
