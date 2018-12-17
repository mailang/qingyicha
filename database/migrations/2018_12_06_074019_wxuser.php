<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wxuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wxuser', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->unique();
            $table->string('nickname');
            $table->string('sex');
            $table->string('province');
            $table->string('city');
            $table->string('country');
            $table->string('mobile');
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
        Schema::dropIfExists('wxuser');
    }
}
