<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecommendTableShopItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_item', function (Blueprint $table) {
            $table->tinyInteger('recommend')->default(0)->comment('是否推荐');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_item', function (Blueprint $table) {
            $table->dropColumn(['recommend']);
        });
    }
}
