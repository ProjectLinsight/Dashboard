<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use DateTime;
use App\Courses ;
use App\User ;

class PersonalCoursesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($course){
        $my_course = DB::table('stu_enrollments')->where('cid',$course)->where('index',Auth::user()->index)->get();

        $course_name  = Courses::where('cid',$course)->get();
        $reg_no = substr(Auth::user()->email,0,9);

        $data = new sharedCourseXapi();
        $cur_course_stmts = $data->getData($course);
        $user_stmts = Array();

        foreach($cur_course_stmts as $st){
            if($st['user']->account->name == $reg_no){
                array_push($user_stmts,$st);
            }
        }

        //Assignments Data

        $activity[] = ['activity', 'Number'];
        $submittedAssignments = array();
        $gradedAssignments = array();
        $activity = array(
            // "Visited" => 0,
            "Viewed" => 0,
            // "Started" => 0,
            "Completed" => 0,
            "Submitted" => 0,
            "Graded" => 0,
            // "Logged in" => 0,
            // "Logged out" => 0,
            "Received" => 0,
            // "Created" => 0,
            // "Other" => 0,
        );

        foreach($user_stmts as $us){
            if("viewed"==$us["verb"]){ $activity["Viewed"]++; }
            // else if("visited"==$us["verb"]){ $activity["Visited"]++; }
            // else if("started"==$us["verb"]){ $activity["Started"]++; }
            else if("completed"==$us["verb"]){
                $activity["Completed"]++;
                array_push($submittedAssignments,$us);
            }
            else if("submitted"==$us["verb"]){
                $activity["Submitted"]++;
                // array_push($submittedAssignments,$us);
            }
            else if("attained grade for"==$us["verb"]){
                $activity["Graded"]++;
                array_push($gradedAssignments,$us);
            }
            // else if("logged into"==$us["verb"]){ $activity["Logged In"]++; }
            // else if("logged out of"==$us["verb"]){ $activity["Logged Out"]++; }
            else if("received"==$us["verb"]){ $activity["Received"]++; }
            // else if("enrolled to"==$us["verb"]){ $activity["Created"]++; }
            // else{ $activity["Other"]++; }
        }

        // dd($gradedAssignments);

        //Quiz Results
        $quizArray = Array();
        foreach($user_stmts as $quiz_stmt){
            if($quiz_stmt['type']=="quiz"){
                array_push($quizArray,$quiz_stmt);
            }
        }

        //dd($quizArray);

        //Dummy data for start date end date
        $today = date("Y-m-d");
        $sDate = strtotime("-1 months", strtotime($today));
        $sDate = date("Y-m-d", $sDate);
        //End of Dummy data for start date end date

        $loop = $sDate;
        while($loop!=$today){
            $date_counts[$loop] = 0;
            $loop = strtotime("+1 day", strtotime($loop));
            $loop = date("Y-m-d", $loop);
        }

        foreach($user_stmts as $us){
            $loop = $sDate;
            while($loop!=$today){
                if($loop==$us["date"]){ $date_counts[$loop]++; }
                $loop = strtotime("+1 day", strtotime($loop));
                $loop = date("Y-m-d", $loop);
            }
        }

        //Results Overview
        $data = DB::table('results')->where('subjectCode',$my_course[0]->cid)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        //End of Results Overview

        return view('student.courses.personal',[
            'crs'=> $course_name[0],
            'gradedAssignments' => $gradedAssignments,
            'submittedAssignments' => $submittedAssignments,
            'quizzes'=>$quizArray
            ])
            ->with('grade', json_encode($array))
            ->with('activity', json_encode($activity))
            ->with('date_counts', json_encode($date_counts))
            ;
    }

    public function datediffInWeeks($date1, $date2)
    {
        $first = DateTime::createFromFormat('Y-m-d', $date1);
        $second = DateTime::createFromFormat('Y-m-d', $date2);
        return floor($first->diff($second)->days/7);
    }
}
