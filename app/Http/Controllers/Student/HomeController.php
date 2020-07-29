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
        $my_enrolled_courses= DB::table('stu_enrollments')->select('cid')->where('index',Auth::user()->index)->get()->toArray();
        $enrolled_courses = Array();
        $enrolled_courses_xapi = Array();
        foreach($my_enrolled_courses as $en){
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

        //Assignemt Reminders 

        $all_assignments = Array();
        foreach($enrolled_courses as $subject){
            $subject_assignments = DB::table('assignments')->where('cid',$subject)->get(['title','weight','dueDate'])->toArray();
            if(count($subject_assignments)>0){
                $all_assignments[$subject] = $subject_assignments;
            }
        }

        //dd($all_assignments);

        //Quiz Reminders
        $all_quizzes = Array();
        foreach($enrolled_courses as $subject){
            $subject_quiz = DB::table('quiz')->where('cid',$subject)->get(['title','dueDate','maxMarks'])->toArray();
            if(count($subject_quiz)>0){
                $all_quizzes[$subject] = $subject_quiz;
            }
            
        }

        //dd($all_quizzes);


        return view('home')
            ->with('activityCount', json_encode($enrolled_courses_xapi))
            ->with('activityOverall', json_encode($activityNested))
            ->with('quiz',$all_quizzes)
            ->with('assignment',$all_assignments)

        ;
    }
}
