<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignLecturer extends Model{
    public function user(){
        return $this->hasOne(User::class,'index', 'lid');
    }
    public function course(){
        return $this->hasOne(Courses::class,'cid','cid');
    }
}
