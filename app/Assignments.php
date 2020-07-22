<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model{
    protected $fillable = [
        'cid', 'title', 'weight', 'dueDate', 'maxMarks'
    ];

    public function user(){
        return $this->hasOne(User::class,'index','index');
    }
    public function course(){
        return $this->hasOne(Courses::class,'cid','cid');
    }
}
