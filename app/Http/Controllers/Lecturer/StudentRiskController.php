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

class StudentRiskController extends Controller{
    public function index($user,$course,$student){
        $crs = DB::table('courses')->where('cid',$course)->get();
        $risk=$this->risk($course);
        $forum=$this->getForum($student,$course);
        $graph_arr=$this->graph($course,$student);
        $cr = DB::table('users')->where('utype','Student')->get();
        $gr = DB::table('stu_enrollments')->where('cid',$course)->get();
        $reg_no = array();
        foreach ($cr as $key => $value) { 
            foreach($gr as $stu){
                if($stu->index==$value->index){
                    $reg=explode("@",$value->email);
                    $r= $reg[0];
                    if($r==$student){
                        $reg_no[$r]['index']=$value->index;
                        $reg_no[$r]['name']=$value->name;
                        $reg_no[$r]['email']=$value->email;
                        $reg_no[$r]['year']=$value->year;
                        $reg_no[$r]['degree']=$value->degree;
                        $reg_no[$r]['asum']=$risk[$r]['asssum'];
                        $reg_no[$r]['aavg']=$risk[$r]['assavg'];
                        $reg_no[$r]['acount']=$risk[$r]['asscount'];
                        $reg_no[$r]['amax']=$risk[$r]['assmax'];
                        $reg_no[$r]['qsum']=$risk[$r]['quizsum'];
                        $reg_no[$r]['qavg']=$risk[$r]['quizavg'];
                        $reg_no[$r]['qcount']=$risk[$r]['quizcount'];
                        $reg_no[$r]['qmax']=$risk[$r]['quizmax'];
                        $reg_no[$r]['rlevel']=$risk[$r]['risklevel'];
                    }
                }
            }  
        }

        // dd($reg_no,$risk);

        // new part

        // $my_course = DB::table('stu_enrollments')->where('cid',$course)->where('index',Auth::user()->index)->get();

        $course_name  = Courses::where('cid',$course)->get();
        // $reg_no = substr(Auth::user()->email,0,9);

        $data = new sharedCourseXapi();
        $cur_course_stmts = $data->getData($course);
        $user_stmts = Array();

        foreach($cur_course_stmts as $st){
            if($st['user']->account->name == $student){
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

        $today = date("Y-m-d");
        $sDate = (DB::table('assign_lecturers')->where('cid',$course)->first())->startDate;
        $sWeek = date("oW", strtotime($sDate));
        // $duration = intval(date("oW",strtotime($today))) - intval(date("oW", strtotime($sDate))) + 1;
        $duration = 15 ;

        //weekly figures
        $weeklyFig = Array();
        for($i=1;$i<$duration;$i++){
            $weeklyFig[$i]= 0 ;
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
            $weeklyFig[$weekNum]++;
        }


        $asmnts = DB::table('assignments')->where('cid',$course)->get();
        $weeklyAssignments = Array();
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
            $weeklyAssignments[$i]= ${"week"."$i"} ;
            $subAssignments[$i]= ${"weekSub"."$i"} ;
        }

        // dd($weeklyAssignments);

        //Results Overview
        $data = DB::table('results')->where('subjectCode',$course)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        //End of Results Overview

        //Viewed Resources
        $viewed_stmts = Array();
        foreach($user_stmts as $vs){
            if($vs['verb']==="viewed" && $vs['object'] != "course"){
                array_push($viewed_stmts,$vs);
            }
        }

        $note=$this->noteCount($course,$student);
        $link=$this->getLinks($student);

        return view('lecturer/student_risk',[
            'crs'=>$course,
            'crs2'=> $course_name[0],
            'stu'=>$student,
            'user'=>$user,
            'gradedAssignments' => $gradedAssignments,
            'submittedAssignments' => $submittedAssignments,
            'weeklyAssignments' => $weeklyAssignments,
            'subAssignments' => $subAssignments,
            'quizzes'=>$quizArray,
            'duration'=> $duration
            ])
            ->with('risks', $risk)
            ->with('stuDetails', $reg_no)
            ->with('grade', json_encode($array))
            ->with('activity', json_encode($activity))
            ->with('date_counts', json_encode($date_counts))
            ->with('week_counts', json_encode($weeklyFig))
            ->with('assGraph', json_encode($graph_arr))
            ->with('notes', $note)
            ->with('risks', $risk)
            ->with('forums', $forum)
            ->with('links', $link);
    }

    public function datediffInWeeks($date1, $date2)
    {
        $first = DateTime::createFromFormat('Y-m-d', $date1);
        $second = DateTime::createFromFormat('Y-m-d', $date2);
        return floor($first->diff($second)->days/7);
    }

    public function noteCount($course,$student)
    {
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
        // foreach($stmt_arr->unique('note') as $note){
        //     $lectNotes[$note]['count']=0;
        //     $lectNotes[$note]['enrolled']=0;
        //   }
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
          //   $distinctass_arr[$s]['note'] = $stmt_arr[$s]['note'] ;
          // $distinctass_arr[$stmt_arr[$s]['note']]['enrolled'] = $enrollCount ; 
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
          
        // dd($distinct_arr,$distinctass_arr);
        return($distinctass_arr);
    }

    public function risk($course){
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $stmt_arr = array();
        $sum_arr = array();
        $count=0;
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="scored" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]->object->definition->name->en ;
                $stmt_arr[$count]['amarks'] = $state[$i]->result->score->raw ;
                $stmt_arr[$count]['amax'] = $state[$i]->result->score->max ;
                $stmt_arr[$count]['qmax'] = 0 ;
                $stmt_arr[$count]['qmarks'] = 0 ;
                $count+=1;
            }
        }
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->object->id);
            if($logArray[sizeof($logArray)-2]==="quiz"){  
                $general=explode("/",$state[$i]->verb->id);
                if($general[sizeof($general)-1]==="completed" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                    $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ; 
                    $stmt_arr[$count]['quiz'] = $state[$i]->object->definition->name->en;
                    $stmt_arr[$count]['qmarks'] = $state[$i]->result->score->raw ;
                    $stmt_arr[$count]['qmax'] = $state[$i]->result->score->max ;
                    $stmt_arr[$count]['amax'] = 0 ;
                    $stmt_arr[$count]['amarks'] = 0 ;
                    $count+=1;
                }
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
                    $assignment[$key]['assmax']+=$stmt_arr[$i]['amax'];
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
        // dd($cr,$count,$stmt_arr,$assignment);
    }


    public function getForum($student,$course){
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $create_arr = array();
        $reply_arr=array();
        $arr=array();
        $countc=0;
        $countr=0;
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="create" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                $create_arr[$countc]['userName'] = $state[$i]->actor->name ;
                $create_arr[$countc]['user'] = $state[$i]->actor->account->name;
                $create_arr[$countc]['forumTopic'] = $state[$i]->context->contextActivities->grouping[2]->definition->name->en;
                $create_arr[$countc]['thread'] = $state[$i]->object->definition->name->en ;
                $create_arr[$countc]['timestamp'] = $state[$i]->stored ;
                $create_arr[$countc]['action'] = "Created" ;
                $create_arr[$countc]['response'] = "-" ;
                $countc+=1;
            }
        }
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="replied" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                $reply_arr[$countr]['userName'] = $state[$i]->actor->name ;
                $reply_arr[$countr]['user'] = $state[$i]->actor->account->name;
                $reply_arr[$countr]['forumTopic'] = $state[$i]->context->contextActivities->grouping[2]->definition->name->en;
                $reply_arr[$countr]['thread'] = $state[$i]->object->definition->name->en ;
                $reply_arr[$countr]['timestamp'] = $state[$i]->stored ;
                $reply_arr[$countr]['response'] = $state[$i]->result->response ;
                $reply_arr[$countr]['action'] = "Replied" ;
                $countr+=1;
            }
        }
        $c=0;
        foreach($create_arr as $key => $value){
            if($create_arr[$key]['user']==$student){
                $arr[$c]=$create_arr[$key];
                $c++;
            }
        }
        foreach($reply_arr as $key => $value){
            if($reply_arr[$key]['user']==$student){
                $arr[$c]=$reply_arr[$key];
                $c++;
            }
        }
        
        // dd($create_arr,$reply_arr,$student,$arr);
        return($arr);
    }

    public function getLinks($student)
    {
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $stmt_arr = array();
        // $student = '2017cs039';
        $count=0;
        for($i=0;$i<$stmt_count;$i++){
                if(isset($state[$i]->verb->display->en)){
                    if(isset($state[$i]->object->definition->description->en)){
                        if($state[$i]->verb->display->en==="Visited" && $state[$i]->actor->name=== $student){
                                $stmt_arr[$count]['user'] = $state[$i]->actor->name ;
                                $stmt_arr[$count]['title'] = $state[$i]->object->definition->name->en ;
                                $stmt_arr[$count]['url'] = $state[$i]->object->definition->description->en ;                            
                                $stmt_arr[$count]['timestamp'] = $state[$i]->timestamp ;
                                $count++;               
                        }
                    }
                        
                }             
        }
        return($stmt_arr) ; 
    }

    public function graph($course,$student){
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $count=0;
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="scored" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                $stmt_arr[$count]['marks'] = $state[$i]->result->score->raw ;
                $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ;
                $stmt_arr[$count]['userName'] = $state[$i]->actor->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]->object->definition->name->en ;
                $stmt_arr[$count]['id'] = $state[$i]->id ;
                $count+=1;
            }
        }
        $st_arr=array();
        $assignment=array();
        $i=0;
        $ass=array();

        if($count!=0){
            foreach($stmt_arr as $key => $value){
                if ($stmt_arr[$key]['user']==$student){
                    
                    $st_arr[$i]['user']=$stmt_arr[$key]['user'];
                    $st_arr[$i]['mark']=$stmt_arr[$key]['marks'];
                    $st_arr[$i]['assignment']=$stmt_arr[$key]['assignment'];
                    $i++;
                }
            }
            $asmnts = DB::table('assignments')->where('cid',$course)->get();
            foreach ($asmnts as $key => $value) { 
                $ass[$value->title]=0; 
            }
            foreach($st_arr as $us => $as){
                foreach($ass as $key => $value){
                    if($key==$st_arr[$us]['assignment']){ 
                        $ass[$key]=$st_arr[$us]['mark']; } 
                }
            }
        }
        
        return($ass);

        // dd($stmt_arr,$st_arr,$asmnts,$ass,$student,$course);

    }

}