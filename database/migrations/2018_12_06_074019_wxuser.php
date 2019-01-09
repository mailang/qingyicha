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
            $table->string('nickname')->nullable();
            $table->string('sex')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('mobile')->nullable();
            $table->string('headimgurl')->nullable();

            $table->string('subscribe')->nullable();
            /*推荐人*/
            $table->string('referee')->default(0);
            /*邀请码*/
            $table->string('code');
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
