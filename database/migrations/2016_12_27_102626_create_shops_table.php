<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id')->comment('商户ID');
            $table->string('name', 100)->comment('商户名称');
            $table->string('image_url', 255)->comment('商户头图');
            $table->unsignedSmallInteger('cat_id')->comment('分类ID');
            $table->unsignedSmallInteger('type_id')->comment('子分类ID');
            $table->string('tel', 20)->comment('商户电话')->unique();
            $table->string('boss_tel', 20)->comment('商户老板电话');
            $table->string('open_time', 100)->comment('营业时间');
            $table->decimal('lat', 10, 6)->comment('纬度');
            $table->decimal('lng', 10, 6)->comment('经度');
            $table->string('addr', 255)->comment('商户地址');
            $table->unsignedTinyInteger('is_vip')->comment('是否VIP商户');
            $table->text('intro')->comment('老板一句话介绍');
            $table->text('menu_image_urls')->comment('菜单图们');
            $table->softDeletes();
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
        Schema::dropIfExists('shops');
    }
}
