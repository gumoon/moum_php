<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderToSpreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spreads', function (Blueprint $table) {
            $table->unsignedSmallInteger('order')->defalut(0)->after('extra')->comment('排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spreads', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
