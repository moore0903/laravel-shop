<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUrlTypeAndAddCatalogTplContentTplCatalog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalogs', function ($table) {
            $table->string('url')->nullable()->change();
            $table->string('catalog_tpl')->comment('栏目模板');
            $table->string('content_tpl')->comment('内容模板');
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
            $table->dropColumn(['catalog_tpl', 'content_tpl']);
        });
    }
}
