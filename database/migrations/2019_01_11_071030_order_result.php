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
            $table->integer('wxuser_id');
            $table->integer('auth_id');
            $table->string('openid');
            $table->string('out_trade_no')->nullable();//订单号
            $table->string('transaction_id')->nullable();//微信订单号
            $table->string('return_code')->nullable();//返回状态值SUCCESS/FAIL
            $table->string('return_msg')->nullable();//return_code为FAIL时的返回值
            $table->string('nonce_str')->nullable();
            $table->string('sign')->nullable();
            $table->string('result_code')->nullable();//业务结果SUCCESS/FAIL
            $table->string('err_code')->nullable();//FAIL时的返回值
            $table->string('trade_type')->nullable();
            /*微信生成的预支付会话标识，用于后续接口调用中使用，该值有效期为2小时*/
            $table->string('prepay_id')->nullable();
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
