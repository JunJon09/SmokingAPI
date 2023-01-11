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
        Schema::create('convenience_stores', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->float('lat', 25, 20);
            $table->float('lng', 25, 20);
            $table->integer('check');
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('convenienceID');
            $table->text('comment');
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
        Schema::dropIfExists('convenience_stores');
        Schema::dropIfExists('comments');
    }
};
