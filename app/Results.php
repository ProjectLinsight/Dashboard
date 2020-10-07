<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Results extends Model{
    protected $fillable = [
        'index', 'grade', 'subjectCode', 'batch','yoe','semester','year'
    ];

    public function user(){
        return $this->hasOne(User::class,'index', 'index');
        // return $this->belongsTo(User::class,'index','index');
    }
    public function course(){
        return $this->hasOne(Courses::class,'cid','subjectCode');
    }
}
