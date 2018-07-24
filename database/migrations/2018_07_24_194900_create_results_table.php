<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned()->comment('所属问卷id');
            $table->integer('grade_id')->nullable()->unsigned()->comment('所属班级');
            $table->text('answer')->comment('答案内容');
            $table->string('name')->nullable()->comment('名称');
            $table->string('email')->nullable()->comment('邮箱');
            $table->integer('number')->nullable()->unsigned()->comment('电话号码');
            $table->enum('sex',['男','女'])->nullable()->comment('性别');
            $table->integer('qq_number')->nullable()->unsigned()->comment('QQ号码');
            $table->string('ip_address')->nullable()->omment('ip地址');
            $table->string('country')->nullable()->omment('国家');
            $table->string('region')->nullable()->omment('地区');
            $table->string('city')->nullable()->omment('城市');
            $table->string('isp')->nullable()->omment('运营商');
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
        Schema::dropIfExists('results');
    }
}
