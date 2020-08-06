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

        return view('student.courses.personal',[
            'crs'=> $course_name[0],
            'gradedAssignments' => $gradedAssignments,
            'submittedAssignments' => $submittedAssignments,
            'weeklyAssignments' => $pendAssignments,
            'subAssignments' => $subAssignments,
            'quizzes'=>$quizArray,
            'duration'=> $duration
            ])
            ->with('grade', json_encode($prevResults))
            ->with('activity', json_encode($activity))
            ->with('date_counts', json_encode($date_counts))
            ->with('week_counts', json_encode($week_counts))
            ->with('assignmentMarks', json_encode($asMarks))
            ;
    }

    // public function getAssignmentData($user_statements){
    //     $activity[] = ['activity', 'Number'];
    //     $submittedAssignments = array();
    //     $gradedAssignments = array();
    //     $assignmentMarks = array();
    //     $activity = array(
    //         "Viewed" => 0,
    //         "Completed" => 0,
    //         "Submitted" => 0,
    //         "Graded" => 0,
    //         "Received" => 0,
    //         // "Visited" => 0,
    //         // "Started" => 0,
    //         // "Logged in" => 0,
    //         // "Logged out" => 0,
    //         // "Created" => 0,
    //         // "Other" => 0,
    //     );

    //     foreach($user_statements as $us){
    //         if("viewed"==$us["verb"]){ $activity["Viewed"]++; }
    //         else if("completed"==$us["verb"]){
    //             $activity["Completed"]++;
    //             // array_push($submittedAssignments,$us);
    //         }
    //         else if("submitted"==$us["verb"]){
    //             $activity["Submitted"]++;
    //             array_push($submittedAssignments,$us);
    //         }
    //         else if("attained grade for"==$us["verb"]){
    //             $activity["Graded"]++;
    //             array_push($gradedAssignments,$us);
    //         }
    //         else if("received"==$us["verb"]){ $activity["Received"]++; }
    //         // else if("visited"==$us["verb"]){ $activity["Visited"]++; }
    //         // else if("started"==$us["verb"]){ $activity["Started"]++; }
    //         // else if("logged into"==$us["verb"]){ $activity["Logged In"]++; }
    //         // else if("logged out of"==$us["verb"]){ $activity["Logged Out"]++; }
    //         // else if("enrolled to"==$us["verb"]){ $activity["Created"]++; }
    //         // else{ $activity["Other"]++; }
    //     }

    //     foreach($gradedAssignments as $graded_stmt){
    //         $temp = Array();
    //         $temp['title'] = $graded_stmt['title'];
    //         $temp['marksObtained'] = $graded_stmt['marks']/$graded_stmt['maxMarks']*100;
    //         array_push($assignmentMarks,$temp);
    //     }

    //     $asMarks = Array();
    //     foreach($assignmentMarks as $as){
    //         $asMarks[$as["title"]]= $as["marksObtained"];
    //     }

    //     return array($activity,$submittedAssignments,$gradedAssignments,$asMarks);
    // }

    // public function getQuizData($user_statements){
    //     $quizArray = Array();
    //     foreach($user_statements as $quiz_stmt){
    //         if($quiz_stmt['type']=="quiz"){
    //             array_push($quizArray,$quiz_stmt);
    //         }
    //     }

    //     return $quizArray;
    // }

    // public function getViewedData($user_statements){
    //     $viewed_stmts = Array();
    //     foreach($user_statements as $vs){
    //         if($vs['verb']==="viewed" && $vs['object'] != "course"){
    //             array_push($viewed_stmts,$vs);
    //         }
    //     }
    //     return $viewed_stmts;
    // }

    // public function getActivityOverTime($user_stmts,$today,$sDate,$duration){
    //     //weekly figures
    //     $week_counts = Array();
    //     for($i=1;$i<$duration;$i++){
    //         $week_counts[$i]= 0 ;
    //     }

    //     //daily figures
    //     $loop = $sDate;
    //     while($loop!=$today){
    //         $date_counts[$loop] = 0;
    //         $loop = strtotime("+1 day", strtotime($loop));
    //         $loop = date("Y-m-d", $loop);
    //     }

    //     foreach($user_stmts as $us){
    //         $loop = $sDate;
    //         while($loop!=$today){
    //             if($loop==$us["date"]){ $date_counts[$loop]++; }
    //             $loop = strtotime("+1 day", strtotime($loop));
    //             $loop = date("Y-m-d", $loop);
    //         }
    //         $weekNum = intval(date("oW",strtotime($us["date"]))) - intval(date("oW", strtotime($sDate))) + 1;
    //         $week_counts[$weekNum]++;
    //     }
    //     return array($date_counts,$week_counts);
    // }

    // public function getPrevResults($courseCode){
    //     $data = DB::table('results')->where('subjectCode',$courseCode)->select(
    //             DB::raw('grade as grade'),
    //             DB::raw('count(*) as number'))
    //         ->groupBy('grade')->get();

    //     $array[] = ['grade', 'Number'];
    //     foreach($data as $key => $value){
    //         $array[++$key] = [$value->grade, $value->number];
    //     }
    //     return $array;
    // }

    // public function getProgressbarPosition($course,$duration,$sDate,$submittedAssignments){
    //     $asmnts = DB::table('assignments')->where('cid',$course)->get();
    //     $pendAssignments = Array();
    //     $subAssignments = Array();
    //     for($i=1;$i<$duration;$i++){
    //         ${"week"."$i"} = Array();
    //         ${"weekSub"."$i"} = Array();
    //     }
    //     $temp = false ;
    //     foreach($asmnts as $as){
    //         foreach($submittedAssignments as $sa){
    //             if($sa["title"] == $as->title){
    //                 $temp = true ;
    //                 continue ;
    //             }
    //         }
    //         $wNo = intval(date("oW",strtotime($as->dueDate))) - intval(date("oW", strtotime($sDate))) + 1;
    //         if($temp){array_push( ${"weekSub"."$wNo"} , $as);}
    //         else{array_push( ${"week"."$wNo"} , $as);}
    //         $temp = false ;
    //     }
    //     for($i=1;$i<$duration;$i++){
    //         $pendAssignments[$i]= ${"week"."$i"} ;
    //         $subAssignments[$i]= ${"weekSub"."$i"} ;
    //     }
    //     return array($subAssignments,$pendAssignments);
    // }
}
