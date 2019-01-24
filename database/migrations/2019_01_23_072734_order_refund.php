<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refund', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('openid');
            $table->string('refundNumber')->nullable();//退单号
            $table->string('transaction_id')->nullable();//微信订单号
            $table->string('out_trade_no')->nullable();//微信订单号
            $table->float('total_fee')->nullable();//订单总金额
            $table->float('refund_fee')->nullable();//实际退款金额
            $table->float('refund_id')->nullable();//微信退款id
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
        Schema::dropIfExists('order_refund');
    }
}
