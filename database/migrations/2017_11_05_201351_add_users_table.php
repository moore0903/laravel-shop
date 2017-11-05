<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_name')->nullable()->comment('真实姓名');
            $table->string('address')->nullable()->comment('地址');
            $table->string('code')->nullable()->comment('邮政编码');
            $table->string('tel')->nullable()->comment('电话');
            $table->string('qq')->nullable()->comment('qq/msn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_name','address','code','tel','qq']);
        });
    }
}
