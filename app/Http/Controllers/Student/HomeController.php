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

            ${"$ec"} = Array();
            $startDate = (DB::table('assign_lecturers')->where('cid',$ec)->first())->startDate;
            $startWeek = date("oW", strtotime($startDate));

            for($i=1;$i<16;$i++){
                ${"$ec"}[$i]= 0 ;
            }
            foreach($data->getData($ec) as $dt){
                $weekNum = intval(date("oW",strtotime($dt["date"]))) - intval(date("oW", strtotime($startDate))) + 1;
                ${"$ec"}[$weekNum]++;
            }
        }

        // $activityNested[] = ['course', 'arr'];
        foreach($enrolled_courses as $ec){
            $activityNested["$ec"] = ${"$ec"} ;
        }
        // dd($activityNested);

        return view('home')
            ->with('activityCount', json_encode($enrolled_courses_xapi))
            ->with('activityOverall', json_encode($activityNested))
        ;
    }
}
