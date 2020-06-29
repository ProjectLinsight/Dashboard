<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerAssigningsTable extends Migration{
    public function up()
    {
        Schema::create('lecturer_assignings', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('lid');
            $table->string('batch');
            $table->string('year');
            $table->string('semeter');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('lecturer_assignings');
    }
}
