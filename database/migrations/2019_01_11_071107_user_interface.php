<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserInterface extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_interface', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interface_id');
            $table->integer('order_id');
            $table->integer('auth_id')->nullable();
            $table->string('openid');
            $table->text('result_code');
            $table->string('url');
            /*查询结果进行系统判断是否有效；1：有效；0无效，用户可以重新查询此接口*/
            $table->integer('state')->default(1);
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
        Schema::dropIfExists('user_interface');
    }
}
