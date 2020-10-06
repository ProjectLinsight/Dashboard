<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use App\Http\Controllers\Shared\sharedStudentCourseData;
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

        //Start Date, Week and Course Duration
        $today = date("Y-m-d");
        $sDate = (DB::table('assign_lecturers')->where('cid',$course)->first())->startDate;
        $sWeek = date("oW", strtotime($sDate));
        $duration = 15 ;
        // $duration = intval(date("oW",strtotime($today))) - intval(date("oW", strtotime($sDate))) + 1;

        //Week data
        $newDate = $sDate ;
        $weeks = Array();
        $datePos = 0 ;
        for($i = 0; $i<15 ; $i++){
            if($newDate<=$today){
                $datePos =  $i;
            }
            $newDate= date("Y-m-d", strtotime("$newDate +1 week"));
            $weeks[$i]= $newDate;
        }

        //Importing xApi Data
        $data = new sharedCourseXapi();
        $cur_course_stmts = $data->getData($course);
        $user_stmts = Array();
        foreach($cur_course_stmts as $st){
            if($st['user']->account->name == $reg_no){
                array_push($user_stmts,$st);
            }
        }

        $currentStuData = new sharedStudentCourseData();

        //Assignments Data
        list($activity,$submittedAssignments,$gradedAssignments,$asMarks) = $currentStuData->getAssignmentData($user_stmts);

        //eliminate duplications
        $gradAssignments = Array();
        foreach($gradedAssignments as $ga){
            $flag = false ;
            if($gradAssignments){
                foreach($gradAssignments as $g){
                    if($ga['title']==$g['title']){
                        $flag = true;
                        break;
                    }
                }
            }else{
                $flag = false ;
            }
            if($flag==false){
                array_push($gradAssignments,$ga);
            }
        }

        //calculating progress on assignments
        $assignmentPosted = DB::table('assignments')->where('cid',$course)->get();
        $totalMarks = 0 ;
        $obtainedMarks = 0 ;
        foreach ($assignmentPosted as $ap) {
            foreach ($gradAssignments as $ga) {
                if($ap->title==$ga['title']){
                    $totalMarks+=$ap->weight;
                    $obtainedMarks += ($ga['marks']/$ga['maxMarks'])*($ap->weight) ;
                }
            }
        }

        //end of calculating progress on assignments
        //Quiz Data
        $quizArray = $currentStuData->getQuizData($user_stmts);

        //Viewed Resources
        $viewed_stmts = $currentStuData->getViewedData($user_stmts);

        // Daily and weekly Figures
        list($date_counts,$week_counts) = $currentStuData->getActivityOverTime($user_stmts,$today,$sDate,$duration);

        // Assignment Positioning on Progress bar
        list($subAssignments,$pendAssignments) = $currentStuData->getProgressbarPosition($course,$duration,$sDate,$submittedAssignments);

        //Previous Results Overview
        $prevResults = $currentStuData->getPrevResults($my_course[0]->cid);


        //Average Assignment Marks
        $averageMarksData = new sharedStudentCourseData();
        $assignmentAvgMarks = $averageMarksData->assignmentStat($course);
        foreach($assignmentAvgMarks as $key => $value) {
            $avgMarks[$key] = $value['avg'];
            $obtMarks[$key] = 0;
            $asNames['AS'.$i++]= $key;
        }
        foreach($gradAssignments as $key => $value) {
            $obtMarks[$value['title']] = $value['marks'];
        }
        $combinedAssignments["Obtained Marks"] = $obtMarks;
        $combinedAssignments["Average Marks"] = $avgMarks;

        return view('student.courses.personal',[
            'crs'=> $course_name[0],
            'gradedAssignments' => $gradAssignments,
            'submittedAssignments' => $submittedAssignments,
            'weeklyAssignments' => $pendAssignments,
            'subAssignments' => $subAssignments,
            'quizzes'=>$quizArray,
            'duration'=> $duration,
            'assignmentNames'=> $asNames,
            'totalMarks' => $totalMarks,
            'obtainedMarks' => $obtainedMarks,
            'weeks' => $weeks,
            'datePosition'=>$datePos
            ])
            ->with('grade', json_encode($prevResults))
            ->with('activity', json_encode($activity))
            ->with('date_counts', json_encode($date_counts))
            ->with('week_counts', json_encode($week_counts))
            ->with('assignmentMarks', json_encode($asMarks))
            ->with('obtMarks', json_encode($obtMarks))
            ->with('avgMarks', json_encode($avgMarks))
            ;
    }

}

