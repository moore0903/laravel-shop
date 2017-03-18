<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnitsUnitNumberTableShopItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_item', function (Blueprint $table) {
            $table->enum('units',['克','斤','个','箱','件'])->default('克')->comment('计量单位');
            $table->string('unit_number')->nullable()->comment('单位数量');
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
            $table->dropColumn(['units','unit_number']);
        });
    }
}
