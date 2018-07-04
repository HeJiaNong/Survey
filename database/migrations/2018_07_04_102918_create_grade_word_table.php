<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_word', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned()->comment('问卷id');
            $table->integer('grade_id')->unsigned()->comment('班级id');
//            $table->integer('count')->unsigned()->default(0)->comment('人数');
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
        Schema::dropIfExists('grade_word');
    }
}
