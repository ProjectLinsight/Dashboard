<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDataTable extends Migration{
    public function up(){
        Schema::create('course_data', function (Blueprint $table) {
            $table->id();
            $table->string('assignmentMarks');
            $table->string('examMarks');
            $table->string('preRequisites');
            $table->string('introduction');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('course_data');
    }
}
