<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStuEnrollmentsTable extends Migration{
    public function up(){
        Schema::create('stu_enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('cid');
            $table->string('index');
            $table->string('year');
            $table->boolean('flag');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('stu_enrollments');
    }
}
