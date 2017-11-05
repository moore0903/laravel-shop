<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCatalogEnTitleAndArticlesSort extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->string('en_title')->nullable()->comment('英文标题');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('sort')->default(100)->comment('排序号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn(['en_title']);
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['sort']);
        });
    }
}
