<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户ID');
            $table->string('realname')->comment('收件人')->nullable();
            $table->string('address')->comment('收件地址')->nullable();
            $table->string('phone')->comment('联系电话')->nullable();
            $table->smallInteger('sequence')->comment('序列')->nullable();
            $table->string('area')->comment('省市区')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
