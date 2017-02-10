<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image_url');
            $table->unsignedSmallInteger('cat_id')->default(1)->comment('分类ID：房产分类=1');
            $table->unsignedSmallInteger('type_id')->default(0)->comment('子分类ID：租房=0');
            $table->unsignedSmallInteger('house_type_id')->comment('房型类型');
            $table->string('tel', 20)->comment('商户电话');
            $table->decimal('lat', 10, 6)->comment('纬度');
            $table->decimal('lng', 10, 6)->comment('经度');
            $table->string('addr', 255)->comment('商户地址');
            $table->string('price', 50)->comment('租金');
            $table->text('detail')->comment('详细介绍');
            $table->unsignedSmallInteger('is_rented')->comment('是否已经租出:0=未租出，1=已租出');
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
        Schema::dropIfExists('rents');
    }
}
