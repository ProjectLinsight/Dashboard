<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentDetails extends Model
{
    public function user(){
        return $this->hasOne(User::class,'index', 'index');
    }
}
