<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReturnFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_fee', function (Blueprint $table) {
            $table->increments('id');
            /*推荐人（返现者）*/
            $table->string('referee');
            /*被推荐人*/
            $table->string('openid');
            /*返现金额*/
            $table->double('fee')->default(0);
            /*订单价格*/
            $table->double('price')->default(0);
            /*0:未返回1:返回未领取第一次2：返回未领第二次3:领取 成功4:撤回*/
            $table->integer('state')->nullable;
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
