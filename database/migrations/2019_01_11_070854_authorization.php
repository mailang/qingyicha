<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Authorization extends Migration
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
            $table->string('entname')->nullable();//企业名称
            $table->string('creditCode')->nullable();//统一的信用代码
            $table->string('licensePlate')->nullable();//车牌号
            $table->integer('carType')->nullable();//车型,值参考文档
            $table->string('vin')->nullable();//车架号
            $table->string('engineNo')->nullable();//发动机号
            $table->string('bankcard')->nullable();//银行卡号
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
