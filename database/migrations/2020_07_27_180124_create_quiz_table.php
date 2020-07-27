<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTable extends Migration
{
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('title');
            $table->string('dueDate');
            $table->string('maxMarks');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz');
    }
}
