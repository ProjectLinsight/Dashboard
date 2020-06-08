<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration{
    public function up(){
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('cName');
            $table->string('cid')->unique();
            $table->string('credits');
            $table->string('type');
            $table->string('semester');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('courses');
    }
}
