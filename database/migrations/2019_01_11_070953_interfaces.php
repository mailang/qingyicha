<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Interfaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interfaces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('interface');//接口简单名称
            $table->string('api_name');//代码调用接口判断
            $table->string('description')->nullable();//接口详细描述
            $table->integer('isenable')->default(0);//1：可用；0：不可用
            $table->integer('pro_id');
            $table->float('price')->default(0);
            $table->integer('sort')->default(1);//排序
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
        Schema::dropIfExists('interfaces');
    }
}
