<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use App\Http\Controllers\Shared\sharedOut_side_dataXapi ;
use App\Http\Controllers\Shared\sharedStudentCourseData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\True_;
use PhpParser\Node\Expr\Cast\Array_;

class HomeController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $reg_no = substr(Auth::user()->email,0,9);
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
        //dd($activityNested);

        //Assignemt Reminders

        $all_assignments = Array();
        foreach($enrolled_courses as $subject){
            $subject_assignments = DB::table('assignments')->where('cid',$subject)->get(['title','weight','dueDate'])->toArray();
            if(count($subject_assignments)>0){
                foreach($subject_assignments as $st){
                    $st->submitted=false;
                }
                $all_assignments[$subject] = $subject_assignments;
            }
        }
        //dd($all_assignments);

        //Quiz Reminders
        $all_quizzes = Array();
        foreach($enrolled_courses as $subject){
            $subject_quiz = DB::table('quiz')->where('cid',$subject)->get(['title','dueDate','maxMarks'])->toArray();
            if(count($subject_quiz)>0){
                foreach($subject_quiz as $sq){
                    $sq->submitted=false;
                }
                $all_quizzes[$subject] = $subject_quiz;
            }

        }

        $enrolled_xapi = Array();
        $xapi_data = new sharedCourseXapi();
        foreach($enrolled_courses as $ec){
            $enrolled_xapi[$ec] = Array();
            $cur_course_stmts = $xapi_data->getData($ec);
            foreach($cur_course_stmts as $st){
                if($st['user']->account->name == $reg_no && $st['verb']==="submitted"){
                    array_push($enrolled_xapi[$ec],$st);
                }
            }
        }

        //dd($enrolled_xapi);


        foreach($all_assignments as $assignment=>$assignment_data){
            foreach($enrolled_xapi as $exapi=>$exapi_data){

                if($assignment===$exapi){
                    foreach($assignment_data as $ad){

                        foreach($exapi_data as $ed){

                            if($ad->title== $ed['title'] && $ed['verb']==="submitted"){
                                $ad->submitted=true;
                            }
                            else{
                                $ad->submitted=false;
                            }

                        }

                    }
                }
            }
        }

        //dd($all_assignments);

        $enrolled_qxapi = Array();
        $xapi_qdata = new sharedCourseXapi();
        foreach($enrolled_courses as $ec){
            $enrolled_qxapi[$ec] = Array();
            $cur_course_stmts = $xapi_qdata->getData($ec);
            foreach($cur_course_stmts as $st){
                if($st['user']->account->name == $reg_no && $st['type']==="quiz"){
                    array_push($enrolled_qxapi[$ec],$st);
                }
            }
        }

        //dd($enrolled_qxapi);

        foreach($all_quizzes as $quiz=>$quiz_data){
            foreach($enrolled_qxapi as $qxapi=>$qxapi_data){
                if($quiz===$qxapi){
                    foreach($quiz_data as $qd){
                        foreach($qxapi_data as $ed){
                            if($qd->title== $ed['title'] && $ed['type']==="quiz" && $ed['verb']==="completed"){
                                $qd->submitted=true;
                            }
                            else{
                                $qd->submitted=false;
                            }
                        }
                    }
                }
            }
        }

        //Outside Data
        $data = new sharedOut_side_dataXapi();
        $state = $data->getData();


        return view('home',['xapi'=>$state])
            ->with('activityCount', json_encode($enrolled_courses_xapi))
            ->with('activityOverall', json_encode($activityNested))
            ->with('quiz',$all_quizzes)
            ->with('assignment',$all_assignments)

        ;
    }
}
