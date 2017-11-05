<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('catalog_id')->comment('分类');
            $table->string('title')->comment('标题');
            $table->text('content')->comment('内容');
            $table->string('img')->comment('图片路径');
            $table->string('author')->nullable()->comment('作者');
            $table->string('browse')->nullable()->comment('浏览量');
            $table->integer('sort')->default(100)->comment('排序号');
            $table->tinyInteger('is_display')->default(1)->comment('是否显示');
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
        Schema::dropIfExists('cases');
    }
}
