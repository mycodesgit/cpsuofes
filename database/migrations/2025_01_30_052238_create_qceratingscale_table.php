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
        Schema::create('qceinstruction', function (Blueprint $table) {
            $table->id();
            $table->integer('inst_scale')->nullable();
            $table->string('inst_descRating')->nullable();
            $table->text('inst_qualDescription')->nullable();
            $table->enum('instratingscalestat', [1, 2])->default(2);
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
        Schema::dropIfExists('qceinstruction');
    }
};
