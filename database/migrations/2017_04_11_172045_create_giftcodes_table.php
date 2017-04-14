<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->string('code')->comment('优惠码')->nullable();
            $table->decimal('discountn',8,2)->default('0.00')->comment('减')->nullable();
            $table->decimal('discountnlimit',8,2)->default('0.00')->comment('满')->nullable();
            $table->integer('usecountmax')->default('1')->comment('总共可使用次数');
            $table->integer('usecount')->default(0)->comment('已使用次数');
            $table->integer('codecount')->default(0)->comment('生成的张数');
            $table->dateTime('start_time')->comment('开始时间');
            $table->dateTime('end_time')->comment('结束时间');
            $table->integer('user_id')->default(0)->comment('领取用户')->nullable();
            $table->integer('p_id')->default(0)->comment('上级id')->nullable();
            $table->string('net')->comment('使用地址')->nullable();
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
        Schema::dropIfExists('giftcodes');
    }
}
