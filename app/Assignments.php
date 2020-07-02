<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignments extends Model{
    public function user(){
        return $this->hasOne(User::class,'index','index');
    }    
    public function course(){
        return $this->hasOne(Courses::class,'cid','cid');
    }
}
