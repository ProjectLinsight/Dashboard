<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model{
    protected $fillable = [
        'cid', 'cName', 'credits', 'type','semester','assignmentMarks','examMarks','prerequisites','introduction'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function results(){
        return $this->hasMany(Results::class,'subjectCode','cid');
    }

    public function lecAssigning(){
        return $this->hasMany(AssignLecturer::class,'cid','cid');
    }

    public function assignment(){
        return $this->hasMany(Assignments::class,'cid','cid');
    }
}
