<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTelAttrToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //遇到同一家商户（电话相同）要被加入不同分类的情况，当然，菜单图也不一样咯
        Schema::table('shops', function (Blueprint $table) {
            $table->dropUnique('shops_tel_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->unique('tel');
        });
    }
}
