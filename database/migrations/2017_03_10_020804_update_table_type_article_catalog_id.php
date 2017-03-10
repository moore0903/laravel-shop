<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableTypeArticleCatalogId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function ($table) {
            $table->dropColumn(['catalog_id']);
            $table->integer('catalogs_id')->references('id')->on('catalogs')->nullable()->comment('分类id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function ($table) {
            $table->dropColumn(['catalogs_id']);
            $table->integer('catalog_id')->references('id')->on('catalogs')->nullable()->comment('分类id');
        });
    }
}
