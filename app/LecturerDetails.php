<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LecturerDetails extends Model
{
    public function user(){
        return $this->hasOne(User::class,'index', 'lecturer_code');
    }
}
