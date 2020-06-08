<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration{
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('index');
            $table->string('grade');
            $table->string('subjectCode');
            $table->string('batch');
            $table->string('yoe');
            $table->string('semester'); 
            $table->string('year'); 
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('results');
    }
}