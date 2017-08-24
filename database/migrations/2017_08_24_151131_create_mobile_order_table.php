<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户id');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('realname')->comment('真实姓名');
            $table->string('nick_name')->nullable()->comment('微信姓名');
            $table->string('phone')->comment('联系方式');
            $table->string('color')->comment('手机颜色');
            $table->string('address')->comment('具体位置');
            $table->string('university')->comment('学校名称');
            $table->string('brand')->comment('手机品牌');
            $table->string('model')->comment('手机型号');
            $table->string('order_time')->comment('预约时间')->nullable();
            $table->text('problem')->comment('手机问题')->nullable();
            $table->text('remark')->comment('用户备注')->nullable();
            $table->tinyInteger('stat')->comment('订单状态');
            $table->string('engineer')->comment('工程师')->nullable();
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
        Schema::dropIfExists('mobile_orders');
    }
}
