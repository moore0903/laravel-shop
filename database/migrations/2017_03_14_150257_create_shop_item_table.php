<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('标题');
            $table->integer('catalog_id')->comment('分类ID');
            $table->integer('count')->default('100')->comment('库存');
            $table->decimal('price')->comment('价格');
            $table->string('img')->comment('预览图')->nullable();
            $table->string('short_title')->comment('短标题')->nullable();
            $table->integer('show')->default('1')->comment('是否显示');
            $table->text('detail')->comment('详情')->nullable();
            $table->integer('sort')->default('100')->comment('排序');
            $table->text('images')->comment('图片集合')->nullable();
            $table->decimal('shipping')->default('0.00')->comment('运费')->nullable();
            $table->decimal('original_price')->comment('原价')->nullable();
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
        Schema::dropIfExists('shop_item');
    }
}
