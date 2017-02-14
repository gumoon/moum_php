<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spreads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable()->comment('描述');
            $table->unsignedInteger('position_id')->comment('位置: 0=外卖商户推荐，1=启动页，2=首页主题列表');
            $table->string('image_url');
            $table->unsignedSmallInteger('flag')->comment('0=网址，1=商户，2=黄页');
            $table->text('extra')->comment('个性化信息');
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
        Schema::dropIfExists('spreads');
    }
}
