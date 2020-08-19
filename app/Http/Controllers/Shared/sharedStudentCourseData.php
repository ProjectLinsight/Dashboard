<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sharedStudentCourseData extends Controller{
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

    public function assignmentStat($course){
        $data = new sharedCourseXapi();
        $state = $data->getData($course);
        $stmt_count = count($state);
        $stmt_arr = array();
        $max_arr = array();
        $min_arr = array();
        $min=100;
        $max=0;
        $avg=0;
        $sum=0;
        $count=0;
        $cr = DB::table('assignments')->where('cid',$course)->get();
        $assignment = array();
        foreach ($cr as $key => $value) {
            $assignment[$value->title]['sum']=0;
            $assignment[$value->title]['max']=0;
            $assignment[$value->title]['min']=100;
            $assignment[$value->title]['avg']=0;
            $assignment[$value->title]['count']=0;
            $assignment[$value->title]['totmax']=0;

        }
        for($i=0;$i<$stmt_count;$i++){
            // $logArray=explode("/",$state[$i]->verb->id);
            if($state[$i]['type']=='assignment'){
                $stmt_arr[$count]['user'] = $state[$i]['user']->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]['title'] ;
                $stmt_arr[$count]['marks'] = $state[$i]['marks'] ;
                $stmt_arr[$count]['maxMarks'] = $state[$i]['maxMarks'] ;
                $sum+=$state[$i]['marks'];
                if($stmt_arr[$count]['marks']>$max){
                    $max=$stmt_arr[$count]['marks'];
                }
                if($stmt_arr[$count]['marks']<$min){
                    $min=$stmt_arr[$count]['marks'];
                }
                $count+=1;
            }
        }
        for($i=0;$i<$count;$i++){
            if($stmt_arr[$i]['marks']===$max){
                $max_arr[$i]['user'] = $stmt_arr[$i]['user'] ;
                $max_arr[$i]['marks'] = $stmt_arr[$i]['marks'] ;
            }
            if($stmt_arr[$i]['marks']===$min){
                $min_arr[$i]['user'] = $stmt_arr[$i]['user'] ;
                $min_arr[$i]['marks'] = $stmt_arr[$i]['marks'] ;
            }
        }

        foreach($assignment as $key => $value){
            for($i=0;$i<$count;$i++){
                if($key==$stmt_arr[$i]['assignment']){
                    $assignment[$key]['count']++;
                    $assignment[$key]['sum']+= $stmt_arr[$i]['marks'];
                    $assignment[$key]['totmax']+= $stmt_arr[$i]['maxMarks'];
                    if($stmt_arr[$i]['marks']>$assignment[$key]['max']){
                        $assignment[$key]['max']=$stmt_arr[$i]['marks'];
                    }
                    if($stmt_arr[$i]['marks']<$assignment[$key]['min']){
                        $assignment[$key]['min']=$stmt_arr[$i]['marks'];
                    }
                }
            }
            if($assignment[$key]['count']!=0){
                $assignment[$key]['avg']=$assignment[$key]['sum']/$assignment[$key]['totmax']*100;
            }
        }
        return($assignment);
    }

    public function noteCount($course,$student){
        $data = new sharedCourseXapi();
        $state = $data->getData($course);
        $stmt_count = count($state);
        $count=0;
        $lectNotes = array();
        $distinct_arr = array();
        $distinctass_arr = array();
        $stmt_arr = array();
        $gr = DB::table('stu_enrollments')->where('cid',$course)->get();
        $enrollCount = count($gr);
        for($i=0;$i<$stmt_count;$i++){
            if($state[$i]['verb']==="viewed" && $state[$i]['object']==="resource" && $state[$i]['user']->name!="Admin User"){
                $stmt_arr[$count]['user'] = $state[$i]['user']->account->name ;
                $stmt_arr[$count]['note'] = $state[$i]['title'] ;
                $count+=1;
            }
        }
          $sub_count = 1;
          $s = 0;
          if($count!=0){
            $distinct_arr[$s]['user'] = $stmt_arr[$s]['user'] ;
            $distinct_arr[$s]['note'] = $stmt_arr[$s]['note'] ;
            for ( $i = 1; $i < $count; $i++)
            {
                for ($j = 0; $j < $i; $j++) {
                    if ($stmt_arr[$i]['user'] == $stmt_arr[$j]['user'] && $stmt_arr[$i]['note'] == $stmt_arr[$j]['note'] )
                       break;
                }
                if ($i == $j){
                    $sub_count++;
                    $s++;
                    $distinct_arr[$s]['user'] = $stmt_arr[$i]['user'] ;
                    $distinct_arr[$s]['note'] = $stmt_arr[$i]['note'] ;
                }
            }
            //get distinct completed assignment list
            $ass_count = 1;
            $s = 0;
            $distinctass_arr[$stmt_arr[$s]['note']]['count'] = 0 ;
            for ( $i = 1; $i < $count; $i++)
            {
                for ($j = 0; $j < $i; $j++) {
                    if ($stmt_arr[$i]['note'] == $stmt_arr[$j]['note'])
                       break;
                }
                if ($i == $j){
                    $ass_count++;
                    $s++;
                  //   $distinctass_arr[$stmt_arr[$i]['note']]['enrolled'] = $enrollCount ;
                    $distinctass_arr[$stmt_arr[$i]['note']]['count'] = 0 ;
                  //   $distinctass_arr[$s]['note'] = $stmt_arr[$i]['note'] ;
                }
            }
            foreach($distinct_arr as $us){
              foreach($distinctass_arr as $key => $value){
                  if($key==$us["note"] && $us['user']==$student){ $distinctass_arr[$key]['count']++; }
              }
           }
          }

        return($distinctass_arr);
    }

    public function risk($course){
        $data = new sharedCourseXapi();
        $state = $data->getData($course);
        $stmt_count = count($state);
        $stmt_arr = array();
        $sum_arr = array();
        $count=0;
        for($i=0;$i<$stmt_count;$i++){
            if($state[$i]['type']=='assignment'){
                $stmt_arr[$count]['user'] = $state[$i]['user']->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]['title'] ;
                $stmt_arr[$count]['amarks'] = $state[$i]['marks'] ;
                $stmt_arr[$count]['amax'] = $state[$i]['maxMarks'] ;
                $stmt_arr[$count]['qmax'] = 0 ;
                $stmt_arr[$count]['qmarks'] = 0 ;
                $count+=1;
            }
        }
        for($i=0;$i<$stmt_count;$i++){
            if($state[$i]['type']=='quiz'){
                    $stmt_arr[$count]['user'] = $state[$i]['user']->account->name ;
                    $stmt_arr[$count]['quiz'] = $state[$i]['title'];
                    $stmt_arr[$count]['qmarks'] = $state[$i]['marks'] ;
                    $stmt_arr[$count]['qmax'] = $state[$i]['maxmarks'] ;
                    $stmt_arr[$count]['amax'] = 0 ;
                    $stmt_arr[$count]['amarks'] = 0 ;
                    $count+=1;

            }
        }
        $avg=0;
        $sum=0;
        $t=0;
        $cr = DB::table('users')->where('utype','Student')->get();
        $gr = DB::table('stu_enrollments')->where('cid',$course)->get();
        $assignment = array();
        $reg_no = array();
        foreach ($cr as $key => $value) {
            foreach($gr as $stu){
                if($stu->index==$value->index){
                    $reg=explode("@",$value->email);
                    $reg_no[$t]= $reg[0];
                     $t++;
                }
            }

        }
        foreach ($reg_no as $key => $value) {
            $assignment[$value]['asssum']=0;
            $assignment[$value]['assavg']=0;
            $assignment[$value]['asscount']=0;
            $assignment[$value]['assmax']=0;
            $assignment[$value]['quizsum']=0;
            $assignment[$value]['quizavg']=0;
            $assignment[$value]['quizcount']=0;
            $assignment[$value]['quizmax']=0;
        }
        foreach($assignment as $key => $value){
            for($i=0;$i<$count;$i++){
                if($key==$stmt_arr[$i]['user'] && $stmt_arr[$i]['qmarks']==0){
                    $assignment[$key]['asscount']++;
                    $assignment[$key]['assmax']+= $stmt_arr[$i]['amax'];
                    $assignment[$key]['asssum']+= $stmt_arr[$i]['amarks'];
                }
                if($key==$stmt_arr[$i]['user'] && $stmt_arr[$i]['amarks']==0){
                    $assignment[$key]['quizcount']++;
                    $assignment[$key]['quizmax']+=$stmt_arr[$i]['qmax'];
                    $assignment[$key]['quizsum']+= $stmt_arr[$i]['qmarks'];
                }
            }
            if($assignment[$key]['assmax']!=0){
                $assignment[$key]['assavg']=($assignment[$key]['asssum']/$assignment[$key]['assmax'])*100;
            }
            if($assignment[$key]['quizmax']!=0){
                $assignment[$key]['quizavg']=($assignment[$key]['quizsum']/$assignment[$key]['quizmax'])*100;
            }
        }
        foreach($assignment as $key => $value){
                if($assignment[$key]['assavg']<=50 && $assignment[$key]['quizavg']<=50 ){
                    $assignment[$key]['risklevel']= "High";
                }
                if($assignment[$key]['assavg']>50 && $assignment[$key]['quizavg']<=50 || $assignment[$key]['assavg']<=50 && $assignment[$key]['quizavg']>50){
                    $assignment[$key]['risklevel']= "Low";
                }
                if($assignment[$key]['assavg']>50 && $assignment[$key]['quizavg']>50 ){
                    $assignment[$key]['risklevel']= "No";
                }
        }
        return ($assignment);
    }

}
