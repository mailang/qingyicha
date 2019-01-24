<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wxuser_id');
            $table->string('openid');
            $table->string('out_trade_no')->nullable();//订单号
            $table->string('transaction_id')->nullable();//微信订单号
            $table->string('body')->nullable();//商品简单描述
            $table->float('total_fee')->nullable();//订单总金额
            $table->float('cash_fee')->nullable();//支付金额
            //  订单状态 0:未支付1：已付款，2：征信接口已成功查询；3.接口已查询存在异常接口
            //-1：超时未支付的无效订单-2:支付失败;-3:订单已退款
            $table->integer('state')->default(0);
            $table->string ('time_start')->nullable();//格式20091225091010
            $table->string ('time_expire')->nullable();//格式20091225091010
            $table->string ('time_pay')->nullable();//支付时间
            $table->integer('pro_id'); //备用字段，接口分类
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
        Schema::dropIfExists('order');
    }
}
