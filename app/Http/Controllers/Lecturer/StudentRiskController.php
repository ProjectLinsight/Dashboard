<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses;
use App\Http\Controllers\Shared\sharedXapi ;
use App\Http\Controllers\Shared\sharedCourseXapi ;

// use App\Stu_enrollment;

class StudentRiskController extends Controller{
    public function index($user,$course,$student){
        $crs = DB::table('courses')->where('cid',$course)->get();
        return view('lecturer/student_risk',[
            'crs'=>$course,
            'stu'=>$student,
            'user'=>$user,
            ]);
    }
}