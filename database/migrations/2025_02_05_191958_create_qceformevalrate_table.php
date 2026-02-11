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
        Schema::create('qceformevalrate', function (Blueprint $table) {
            $table->id();
            $table->integer('[ratecount]')->nullable();
            $table->integer('[subjidrate]')->nullable();
            $table->string('[prog]')->nullable();
            $table->string('campus')->nullable();
            $table->enum('statprint', ['1', '2'])->default('1');
            $table->integer('qceschlyearsemID')->nullable();
            $table->string('schlyear')->nullable();
            $table->string('semester')->nullable();
            $table->string('ratingfromto')->nullable();
            $table->integer('qcesubjID')->nullable();
            $table->integer('qcesubjName')->nullable();
            $table->integer('qcefacID')->nullable();
            $table->string('qcefacname')->nullable();
            $table->string('qceevaluator')->nullable();
            $table->string('question')->nullable();
            $table->string('question_rate')->nullable();
            $table->text('qcecomments')->nullable();
            $table->string('evaluatorname')->nullable();
            $table->integer('evaluatorID')->nullable();
            $table->string('studidno')->nullable();
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
        Schema::dropIfExists('qceformevalrate');
    }
};
