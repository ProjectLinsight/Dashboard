<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model{
    protected $fillable = [
        'cid', 'cName', 'credits', 'type','semester'
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
}
