<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('问卷模板名称');
            $table->integer('category_id')->unsigned()->comment('问卷类型');
            $table->text('describe')->nullable()->comment('描述');
            $table->text('content')->nullable()->comment('问卷内容');
            $table->string('qrcode')->nullable()->comment('二维码地址');
            $table->text('topics_html')->comment('每个题目html代码');
            $table->boolean('status')->default(false)->comment('状态：1启用，0停用');
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
        Schema::dropIfExists('words');
    }
}
