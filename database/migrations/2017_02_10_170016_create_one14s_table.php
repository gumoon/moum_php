<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOne14sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one14s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image_url');
            $table->unsignedSmallInteger('cat_id')->comment('分类ID');
            $table->unsignedSmallInteger('type_id')->comment('子分类ID');
            $table->string('tel', 20)->comment('商户电话');
            $table->unsignedSmallInteger('is_vip')->comment('0=非vip,1=vip');
            $table->decimal('lat', 10, 6)->comment('纬度');
            $table->decimal('lng', 10, 6)->comment('经度');
            $table->string('addr', 255)->comment('商户地址');
            $table->string('tags', 255)->comment('标签列表，用分号分隔');
            $table->text('detail')->comment('详细介绍');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one14s');
    }
}
