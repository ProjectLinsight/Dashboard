<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration{
    public function up(){
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('title');
            $table->string('weight');
            $table->string('dueDate');
            $table->string('maxMarks');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('assignments');
    }
}
