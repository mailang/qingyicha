<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wemenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wemenu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid')->default(0);
            /*菜单的响应动作类型，view表示网页类型，click表示点击类型，miniprogram表示小程序类型*/
            $table->string('type');
            /*	菜单标题，不超过16个字节，子菜单不超过60个字节*/
            $table->string('name');
            /*click等点击类型必须	菜单KEY值，用于消息接口推送，不超过128字节*/
            $table->string('key')->nullable();
            /*view、miniprogram类型必须*/
            $table->string('url')->nullable();
            /*media_id类型和view_limited类型必须,调用新增永久素材接口返回的合法media_id*/
            $table->string('media_id')->nullable();
            /*小程序id*/
            $table->string('appid')->nullable();
            /*小程序页面路径*/
            $table->string('pagepath')->nullable();
            /*是否允许有子集0:不允许添加子菜单，1:允许添加子菜单*/
            $table->integer('sub')->default(0);
            /*可用状态0:不可用;1:可用*/
            $table->integer('enable')->default(1);
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
        //
    }
}
