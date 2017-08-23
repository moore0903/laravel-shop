<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->references('id')->on('mobile_brand')->comment('品牌ID');
            $table->string('model_name')->comment('型号名称');
            $table->integer('sort')->default('0')->comment('排序号');
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
        Schema::dropIfExists('mobile_model');
    }
}
