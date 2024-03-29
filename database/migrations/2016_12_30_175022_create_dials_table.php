<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dials', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shop_id');
            $table->string('uuid', 100)->comment('设备唯一码');
            $table->unsignedTinyInteger('client_id')->comment('客户端ID');
            $table->timestamp('created_at');
            //此处没有加外键，仍然可以访问shop
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dials');
    }
}
