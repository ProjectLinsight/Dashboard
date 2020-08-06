<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sharedStudentCourseData extends Controller
{
    public function getAssignmentData($user_statements){
        $activity[] = ['activity', 'Number'];
        $submittedAssignments = array();
        $gradedAssignments = array();
        $assignmentMarks = array();
        $activity = array(
            "Viewed" => 0,
            "Completed" => 0,
            "Submitted" => 0,
            "Graded" => 0,
            "Received" => 0,
            // "Visited" => 0,
            // "Started" => 0,
            // "Logged in" => 0,
            // "Logged out" => 0,
            // "Created" => 0,
            // "Other" => 0,
        );

        foreach($user_statements as $us){
            if("viewed"==$us["verb"]){ $activity["Viewed"]++; }
            else if("completed"==$us["verb"]){
                $activity["Completed"]++;
                // array_push($submittedAssignments,$us);
            }
            else if("submitted"==$us["verb"]){
                $activity["Submitted"]++;
                array_push($submittedAssignments,$us);
            }
            else if("attained grade for"==$us["verb"]){
                $activity["Graded"]++;
                array_push($gradedAssignments,$us);
            }
            else if("received"==$us["verb"]){ $activity["Received"]++; }
            // else if("visited"==$us["verb"]){ $activity["Visited"]++; }
            // else if("started"==$us["verb"]){ $activity["Started"]++; }
            // else if("logged into"==$us["verb"]){ $activity["Logged In"]++; }
            // else if("logged out of"==$us["verb"]){ $activity["Logged Out"]++; }
            // else if("enrolled to"==$us["verb"]){ $activity["Created"]++; }
            // else{ $activity["Other"]++; }
        }

        foreach($gradedAssignments as $graded_stmt){
            $temp = Array();
            $temp['title'] = $graded_stmt['title'];
            $temp['marksObtained'] = $graded_stmt['marks']/$graded_stmt['maxMarks']*100;
            array_push($assignmentMarks,$temp);
        }

        $asMarks = Array();
        foreach($assignmentMarks as $as){
            $asMarks[$as["title"]]= $as["marksObtained"];
        }

        return array($activity,$submittedAssignments,$gradedAssignments,$asMarks);
    }

    public function getQuizData($user_statements){
        $quizArray = Array();
        foreach($user_statements as $quiz_stmt){
            if($quiz_stmt['type']=="quiz"){
                array_push($quizArray,$quiz_stmt);
            }
        }

        return $quizArray;
    }

    public function getViewedData($user_statements){
        $viewed_stmts = Array();
        foreach($user_statements as $vs){
            if($vs['verb']==="viewed" && $vs['object'] != "course"){
                array_push($viewed_stmts,$vs);
            }
        }
        return $viewed_stmts;
    }

    public function getActivityOverTime($user_stmts,$today,$sDate,$duration){
        //weekly figures
        $week_counts = Array();
        for($i=1;$i<$duration;$i++){
            $week_counts[$i]= 0 ;
        }

        //daily figures
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
            $weekNum = intval(date("oW",strtotime($us["date"]))) - intval(date("oW", strtotime($sDate))) + 1;
            $week_counts[$weekNum]++;
        }
        return array($date_counts,$week_counts);
    }

    public function getPrevResults($courseCode){
        $data = DB::table('results')->where('subjectCode',$courseCode)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        return $array;
    }

    public function getProgressbarPosition($course,$duration,$sDate,$submittedAssignments){
        $asmnts = DB::table('assignments')->where('cid',$course)->get();
        $pendAssignments = Array();
        $subAssignments = Array();
        for($i=1;$i<$duration;$i++){
            ${"week"."$i"} = Array();
            ${"weekSub"."$i"} = Array();
        }
        $temp = false ;
        foreach($asmnts as $as){
            foreach($submittedAssignments as $sa){
                if($sa["title"] == $as->title){
                    $temp = true ;
                    continue ;
                }
            }
            $wNo = intval(date("oW",strtotime($as->dueDate))) - intval(date("oW", strtotime($sDate))) + 1;
            if($temp){array_push( ${"weekSub"."$wNo"} , $as);}
            else{array_push( ${"week"."$wNo"} , $as);}
            $temp = false ;
        }
        for($i=1;$i<$duration;$i++){
            $pendAssignments[$i]= ${"week"."$i"} ;
            $subAssignments[$i]= ${"weekSub"."$i"} ;
        }
        return array($subAssignments,$pendAssignments);
    }
}
