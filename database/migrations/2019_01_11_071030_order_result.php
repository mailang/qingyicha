<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderResult extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void 支付返回结果保存
     */
    public function up()
    {
        Schema::create('order_result', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid');
            $table->integer('order_id');
            $table->string('out_trade_no')->nullable();//订单号
            $table->string('transaction_id')->nullable();//微信订单号
            $table->string('return_code')->nullable();//返回状态值SUCCESS/FAIL
            $table->string('result_code')->nullable();//return_code为FAIL时的返回值
            $table->text('result')->nullable();//微信端返回xml记录
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
        Schema::dropIfExists('order_result');
    }
}
