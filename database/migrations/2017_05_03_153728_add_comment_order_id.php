<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentOrderId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment', function (Blueprint $table) {
            $table->integer('order_id')->comment('订单ID')->nullable();
            $table->integer('order_detail_id')->comment('订单详情ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment', function (Blueprint $table) {
            $table->dropColumn(['order_id','order_detail_id']);
        });
    }
}
