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
        Schema::create('qcequestion', function (Blueprint $table) {
            $table->id();
            $table->integer('catName_id')->nullable();
            $table->text('questiontext')->nullable();
            $table->enum('questcat', ['1', '2'])->nullable();
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
        Schema::dropIfExists('qcequestion');
    }
};
