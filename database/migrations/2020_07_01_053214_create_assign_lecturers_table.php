<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignLecturersTable extends Migration{
    public function up()
    {
        Schema::create('assign_lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('lid');
            $table->string('year');
            $table->string('startDate');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('assign_lecturers');
    }
}
