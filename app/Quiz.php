<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model{
    protected $table = 'quiz';
    protected $fillable = [
        'cid', 'title', 'dueDate', 'maxMarks'
    ];

    public function user(){
        return $this->hasOne(User::class,'index','index');
    }
    public function course(){
        return $this->hasOne(Courses::class,'cid','cid');
    }
}
