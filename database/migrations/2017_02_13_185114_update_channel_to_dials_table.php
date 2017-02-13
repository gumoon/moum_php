<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateChannelToDialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dials', function (Blueprint $table) {
            $table->unsignedInteger('one14_id')->nullable()->after('shop_id');
            // $table->unsignedSmallInteger('channel_id')->default(0)->comment('频道：0=外卖；1=黄页')->after('user_id');
            $table->unsignedInteger('shop_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dials', function (Blueprint $table) {
            $table->dropColumn('one14_id');
            $table->unsignedInteger('shop_id')->change();
            // $table->dropColumn('channel_id');
        });
    }
}
