<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentDataTable extends Migration{
    public function up(){
        Schema::create('student_data', function (Blueprint $table) {
            $table->id();
            $table->string('index');
            
            $table->string('sub11');
            $table->string('res11');
            $table->string('credits11'); 
            $table->float('gpa11');
            $table->float('totCredits11');
            $table->string('sub12');
            $table->string('res12');
            $table->string('credits12'); 
            $table->float('gpa12');
            $table->float('totCredits12');

            $table->string('sub21');
            $table->string('res21');
            $table->string('credits21'); 
            $table->float('gpa21');
            $table->float('totCredits21');
            $table->string('sub22');
            $table->string('res22');
            $table->string('credits22'); 
            $table->float('gpa22');
            $table->float('totCredits22');
    
            $table->string('sub31');
            $table->string('res31');
            $table->string('credits31'); 
            $table->float('gpa31');
            $table->float('totCredits31');
            $table->string('sub32');
            $table->string('res32');
            $table->string('credits32'); 
            $table->float('gpa32');
            $table->float('totCredits32');

            $table->string('sub41');
            $table->string('res41');
            $table->string('credits41'); 
            $table->float('gpa41');
            $table->float('totCredits41');
            $table->string('sub42');
            $table->string('res42');
            $table->string('credits42'); 
            $table->float('gpa42');
            $table->float('totCredits42');
            
            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('student_data');
    }
}
