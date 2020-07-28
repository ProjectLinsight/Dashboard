<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Stu_enrollment extends Model{
    use Notifiable;
    
    public function user(){
        return $this->hasOne(User::class,'index','index');
    }
    public function course(){
        return $this->hasOne(Courses::class,'cid','cid');
    }
}
