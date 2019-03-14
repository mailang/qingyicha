<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProInterface extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pro_interface', function (Blueprint $table) {
            $table->increments('id');
            /*接口id*/
            $table->integer('interface_id')->unsigned();
            $table->integer('pro_id')->unsigned();
            $table->integer('isenable')->default(0);
            $table->timestamps();
            $table->foreign('interface_id')->references('id')->on('interfaces')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pro_id')->references('id')->on('product')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pro_interface');
    }
}
