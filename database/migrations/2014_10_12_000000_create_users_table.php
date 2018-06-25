<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('姓名');
            $table->enum('sex',['男','女','保密'])->default('保密')->comment('性别');
            $table->string('email')->unique()->comment('邮箱');
            $table->string('password',255)->comment('密码');
            $table->string('number',30)->comment('电话号码');
            $table->string('addr')->nullable()->comment('地址');
            $table->boolean('status')->default(true)->comment('状态/0停用/1启用');
            $table->rememberToken()->comment('是否记住用户');
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
        Schema::dropIfExists('users');
    }
}
