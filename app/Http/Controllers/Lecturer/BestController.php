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

class BestController extends Controller{
    public function index($user,$course){
        $crs = DB::table('courses')->where('cid',$course)->get();
        $cr = DB::table('users')->where('utype','Student')->get();
        $gr = DB::table('stu_enrollments')->where('cid',$course)->get();

        return view('lecturer/best_performance',[
            'crs'=>$course,
            'user'=>$user,
            ]);
    }



}