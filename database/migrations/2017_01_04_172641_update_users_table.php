<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tel', 50)->after('email');
            $table->string('profile_image_url', 255)->nullable()->after('password');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别：0=未知，1=男，2=女')->after('profile_image_url');
            
            $table->string('name')->nullable()->change();
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tel', 'profile_image_url', 'gender', 'deleted_at']);
        });
    }
}
