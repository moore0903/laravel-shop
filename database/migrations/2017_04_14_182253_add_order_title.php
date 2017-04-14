<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户id');
            $table->string('serial')->comment('订单编号');
            $table->string('address')->comment('收货地址');
            $table->string('realname')->comment('收货人');
            $table->string('phone')->comment('收货人电话');
            $table->tinyInteger('stat')->comment('状态');
            $table->decimal('total',8,2)->default('0.00')->comment('原价');
            $table->decimal('discount',8,2)->default('0.00')->comment('优惠价');
            $table->decimal('totalpay',8,2)->default('0.00')->comment('现价');
            $table->tinyInteger('paytype')->comment('支付类型')->nullable();
            $table->string('trade_no')->comment('支付编号')->nullable();
            $table->dateTime('notify_time')->comment('支付时间')->nullable();
            $table->text('memo')->comment('管理员备注')->nullable();
            $table->decimal('totalget',8,2)->default('0.00')->comment('支付金额');
            $table->integer('giftcode_id')->references('id')->on('giftcodes')->nullable()->comment('优惠券ID');
            $table->integer('pay_order_id')->references('id')->on('pay_order')->nullable()->comment('支付表ID');
            $table->text('progress')->comment('流程')->nullable();
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->references('id')->on('orders')->nullable()->comment('Order表id');
            $table->integer('shop_item_id')->references('id')->on('shop_item')->nullable()->comment('商品表id');
            $table->string('product_title')->comment('商品名称');
            $table->integer('product_num')->comment('商品数量');
            $table->string('thumbnail')->comment('商品缩略图');
            $table->decimal('product_price',8,2)->comment('商品价格');
            $table->string('shop_item_catalog')->comment('商品分类');
            $table->timestamps();
        });

        Schema::create('pay_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->references('id')->on('orders')->nullable()->comment('Order表id');
            $table->string('subject');
            $table->decimal('total',8,2)->default('0.00')->comment('原价');
            $table->decimal('discount',8,2)->default('0.00')->comment('优惠价');
            $table->decimal('totalpay',8,2)->default('0.00')->comment('现价');
            $table->tinyInteger('paytype')->comment('支付类型')->nullable();
            $table->string('trade_no')->comment('支付编号')->nullable();
            $table->decimal('totalget',8,2)->default('0.00')->comment('支付金额');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('pay_order');
    }
}
