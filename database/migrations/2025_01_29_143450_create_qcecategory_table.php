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
        Schema::create('qcecategory', function (Blueprint $table) {
            $table->id();
            $table->string('catName')->nullable();
            $table->text('catDesc')->nullable();
            $table->enum('catstatus', [1, 2, 3])->default(1);
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
        Schema::dropIfExists('qcecategory');
    }
};
