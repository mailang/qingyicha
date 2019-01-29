<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class  Authorization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('authorization', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid');
            $table->string('name');//姓名
            $table->string('phone');//手机号
            $table->string('cardNo');//身份证号
            $table->string('authorizedPhoto')->nullable();//人工授权照片
            $table->integer('state')->default(0);//人工授权照片
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
        Schema::dropIfExists('authorization');
    }
}
