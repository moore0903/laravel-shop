<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopItmeCommentSalesCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_item', function (Blueprint $table) {
            $table->integer('sellcount_real')->default('0')->comment('真实销量')->nullable();
            $table->integer('sellcount_false')->default('0')->comment('虚假销量')->nullable();
        });

        Schema::create('collection', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户ID');
            $table->string('shop_item_id')->references('id')->on('shop_item')->comment('商品ID')->nullable();
        });

        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户ID');
            $table->string('shop_item_id')->references('id')->on('shop_item')->comment('商品ID')->nullable();
            $table->text('content')->comment('评论内容')->nullable();
            $table->text('images')->comment('评论图片')->nullable();
            $table->tinyInteger('star')->comment('评论星级')->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['sellcount_real','sellcount_false']);
        });

        Schema::dropIfExists('collection');

        Schema::dropIfExists('comment');
    }
}
