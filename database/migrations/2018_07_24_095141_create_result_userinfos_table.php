<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultUserinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_userinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned()->comment('所属问卷id');
            $table->string('name')->nullable()->comment('名称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->integer('number')->nullable()->unsigned()->comment('电话号码');
            $table->enum('sex',['男','女'])->nullable()->comment('性别');
            $table->integer('qq_number')->nullable()->unsigned()->comment('QQ号码');
            $table->string('ip_address')->nullable()->omment('ip地址');
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
        Schema::dropIfExists('result_userinfos');
    }
}
