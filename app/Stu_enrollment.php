<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stu_enrollment extends Model{
    public function user(){
        return $this->hasOne(User::class,'index','index');
    }
}
