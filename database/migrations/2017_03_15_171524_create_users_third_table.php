<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersThirdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_third', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable()->comment('用户ID');
            $table->integer('standard_id')->comment('第三方ID');
            $table->string('platform')->comment('用户来源');
            $table->string('nick_name')->nullable()->comment('用户昵称');
            $table->string('name')->nullable()->comment('用户名');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->text('extdata')->nullable()->comment('第三方详情');
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
        Schema::dropIfExists('users_third');
    }
}
