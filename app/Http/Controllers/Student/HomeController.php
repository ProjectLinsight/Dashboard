<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $my_statements = DB::table('stu_enrollments')->select('cid')->where('index',Auth::user()->index)->get()->toArray();
        $enrolled_courses = Array();
        $enrolled_courses_xapi = Array();
        foreach($my_statements as $en){
            $temp = $en->cid;
            array_push($enrolled_courses,$temp);
        }

        $data = new sharedCourseXapi();
        foreach($enrolled_courses as $ec){
            $cur_course_stmts = $data->getData($ec);
            $cur_course_count = count($cur_course_stmts);
            $enrolled_courses_xapi[$ec] = $cur_course_count;
        }

        // dd($enrolled_courses_xapi);

        return view('home')->with('activityCount', json_encode($enrolled_courses_xapi));
    }
}
