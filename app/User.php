<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'utype', 'password','year','degree','index'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function stuData(){
        if($this->utype == 'Student') return $this->hasOne(StudentData::class,'index','index');
    }

    public function stu_enrollment(){
        if($this->utype == 'Student') return $this->hasMany(StudentData::class,'index','index');
    }

    public function posts(){
        return $this->hasMany(Post::class)->orderBy('updated_at','DESC');
    }

    public function courses(){
        return $this->hasMany(Courses::class);
    }    

    public function results(){
        if($this->utype == 'Student') return $this->hasMany(Results::class,'index','index');
    }
    public function lecturerDetails(){
        if($this->utype == 'Lecturer') return $this->hasOne(LecturerDetails::class,'lecturer_code','index');
    }
    public function studentDetails(){
        if($this->utype == 'Student') return $this->hasOne(StudentDetails::class,'index','index');
    }
}
