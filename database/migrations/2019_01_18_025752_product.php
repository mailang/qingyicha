<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pro_name');
            /*产品调用函数名识别（可能存在多个接口营运商）*/
            $table->string('module')->nullable();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->float('price')->default(0);
            /*返现推荐人的金额*/
            $table->float('return_fee')->default(0);
            /*1：添加到app首页显示0：代码中可能使用到*/
            $table->integer('isindex')->default(0);

            $table->integer('isenable')->default(1);
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
        Schema::dropIfExists('product');
    }
}
