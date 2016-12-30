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
            $table->integer('uid');
            $table->integer('shop_id');
            $table->string('uuid', 100);
            $table->unsignedTinyInteger('client_id');
            $table->timestamp('created_at');
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
