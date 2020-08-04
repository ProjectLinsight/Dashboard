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

class LecturerOverviewController extends Controller{
    public function index($user,$course){
        $crs = DB::table('courses')->where('cid',$course)->get();
        $stmt_arr = array();
        $q_arr = array();
        $stat = array();
        if(substr($course,0,1)=='I'){
            $degree = "Information Systems";
        } else if(substr($course,0,1)=='S'){
            $degree = "Computer Science";
        } 

        $stu = DB::table('users')->where('utype','Student')->where('degree',$degree)->get();
        $enrolled = count(DB::table('stu_enrollments')->where('cid',$course)->get());
        $stmt_arr=$this->assignmentComp($course);
        $q_arr=$this->quizComp($course);
        $stat=$this->assignmentStat($course);
        $risk=$this->risk($course);
        $bestp=$this->best($course);
        $note=$this->noteCount($course);
        $quizstat=$this->quizStat($course);
        return view('lecturer/overview',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            'enrolled'=>$enrolled,
            ])
            ->with('assignment', json_encode($stmt_arr))
            ->with('quiz', json_encode($q_arr))
            ->with('stats', $stat)
            ->with('risks', $risk)
            ->with('best', $bestp)
            ->with('user', $user)
            ->with('course',$course)
            ->with('quizstats', $quizstat)
            ->with('notes', $note);
        return view('lecturer/student_risk',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            ])
            ->with('risks', $risk)
            ->with('best', $bestp)
            ->with('user', $user)
            ->with('course',$course);
        return view('lecturer/best_performance',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            ])
            ->with('best', $bestp)
            ->with('user', $user)
            ->with('course',$course);
    }


   
    public function assignmentStat($course)
    {
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
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        foreach ($cr as $key => $value) { 
            $assignment[$value->title]['sum']=0; 
            $assignment[$value->title]['max']=0; 
            $assignment[$value->title]['min']=100; 
            $assignment[$value->title]['avg']=0;
            $assignment[$value->title]['count']=0;  
        }
        for($i=0;$i<$stmt_count;$i++){            
            // $logArray=explode("/",$state[$i]->verb->id);
            if($state[$i]['type']=='assignment'){
                $stmt_arr[$count]['user'] = $state[$i]['user']->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]['title'] ;
                $stmt_arr[$count]['marks'] = $state[$i]['marks'] ;
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
        // $avg=$sum/$count;

        foreach($assignment as $key => $value){
            for($i=0;$i<$count;$i++){
                if($key==$stmt_arr[$i]['assignment']){
                    $assignment[$key]['count']++;
                    $assignment[$key]['sum']+= $stmt_arr[$i]['marks'];
                    if($stmt_arr[$i]['marks']>$assignment[$key]['max']){
                        $assignment[$key]['max']=$stmt_arr[$i]['marks'];
                    }
                    if($stmt_arr[$i]['marks']<$assignment[$key]['min']){
                        $assignment[$key]['min']=$stmt_arr[$i]['marks'];
                    }
                }
            }
            if($assignment[$key]['count']!=0){
                $assignment[$key]['avg']=$assignment[$key]['sum']/$assignment[$key]['count'];
            }
        }
        return($assignment);
        // dd($max,$max_arr,$min,$min_arr,$avg,$stmt_arr,$assignment);
        // $data2 = new sharedCourseXapi();
        // $state2 = $data2->getData();
        // dd($state2);
    }

    public function quizStat($course)
    {
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
        $cr = DB::table('quiz')->where('cid',$course)->get();
        $quiz = array();
        foreach ($cr as $key => $value) { 
            $quiz[$value->title]['sum']=0; 
            $quiz[$value->title]['max']=0; 
            $quiz[$value->title]['min']=100; 
            $quiz[$value->title]['avg']=0;
            $quiz[$value->title]['count']=0;  
        }
        for($i=0;$i<$stmt_count;$i++){            
            // $logArray=explode("/",$state[$i]->verb->id);
            if($state[$i]['type']==="quiz"){
                $stmt_arr[$count]['user'] = $state[$i]['user'] ;
                $stmt_arr[$count]['assignment'] = $state[$i]['title'] ;
                $stmt_arr[$count]['marks'] = $state[$i]['marks'] ;
                $stmt_arr[$count]['maxmark'] = $state[$i]['maxmarks'] ;
                $count+=1;
            }
        }

        foreach($quiz as $key => $value){
            for($i=0;$i<$count;$i++){
                if($key==$stmt_arr[$i]['assignment']){
                    $quiz[$key]['count']++;
                    $quiz[$key]['sum']+= $stmt_arr[$i]['marks'];
                    if($stmt_arr[$i]['marks']>$quiz[$key]['max']){
                        $quiz[$key]['max']=$stmt_arr[$i]['marks'];
                    }
                    if($stmt_arr[$i]['marks']<$quiz[$key]['min']){
                        $quiz[$key]['min']=$stmt_arr[$i]['marks'];
                    }
                }
            }
            if($quiz[$key]['count']!=0){
                $quiz[$key]['avg']=$quiz[$key]['sum']/$quiz[$key]['count'];
            }
        }
        return($quiz);
        // dd($max,$max_arr,$min,$min_arr,$avg,$stmt_arr,$quiz);
        // $data2 = new sharedCourseXapi();
        // $state2 = $data2->getData();
        // dd($state2);
    }

    public function xapitest()
    {
        $data = new sharedCourseXapi();
        $state = $data->getData('SCS3109');
        dd($state);
    }

    public function noteCount($course)
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
          $distinctass_arr[$stmt_arr[$s]['note']]['enrolled'] = $enrollCount ; 
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
                    $distinctass_arr[$stmt_arr[$i]['note']]['enrolled'] = $enrollCount ; 
                    $distinctass_arr[$stmt_arr[$i]['note']]['count'] = 0 ; 
                  //   $distinctass_arr[$s]['note'] = $stmt_arr[$i]['note'] ; 
                }
            }
            foreach($distinct_arr as $us){
              foreach($distinctass_arr as $key => $value){
                  if($key==$us["note"]){ $distinctass_arr[$key]['count']++; } 
              }
           }
          }
          
        // dd($distinct_arr,$distinctass_arr);
        return($distinctass_arr);
    }

    public function assignmentComp($course)
    {
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $count=0;
        $stmt_arr = array();
        $distinct_arr = array();
        $distinctass_arr = array();
        $ass_list = array();
        $assignment = array();
        $notcom_array = array();
        $result = 0;
        $crs = DB::table('users')->get();
        $all_count = count($crs);
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="submit" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]->object->definition->name->en;
                $count+=1;
            }
            // elseif($logArray[sizeof($logArray)-1]==="scored"){
            //     $stmt_arr[$count]['marks'] = $state[$i]->result->score->raw ;
            //     $stmt_arr[$count]['user'] = $state[$i]->actor ;
            // }
        }
        //get distinct assignment completed users
        if($count!=0){
            $sub_count = 1; 
            $s = 0;
            $distinct_arr[$s]['user'] = $stmt_arr[$s]['user'] ;
            $distinct_arr[$s]['assignment'] = $stmt_arr[$s]['assignment'] ;
            for ( $i = 1; $i < $count; $i++) 
            { 
                for ($j = 0; $j < $i; $j++) {
                    if ($stmt_arr[$i]['user'] == $stmt_arr[$j]['user'] && $stmt_arr[$i]['assignment'] == $stmt_arr[$j]['assignment'] ) 
                       break; 
                }
                if ($i == $j){ 
                    $sub_count++;
                    $s++;
                    $distinct_arr[$s]['user'] = $stmt_arr[$i]['user'] ;
                    $distinct_arr[$s]['assignment'] = $stmt_arr[$i]['assignment'] ; 
                }
            }
            //get distinct completed assignment list
            $ass_count = 1; 
            $s = 0;
            $distinctass_arr[$s]['assignment'] = $stmt_arr[$s]['assignment'] ;
            for ( $i = 1; $i < $count; $i++) 
            { 
                for ($j = 0; $j < $i; $j++) {
                    if ($stmt_arr[$i]['assignment'] == $stmt_arr[$j]['assignment']) 
                       break; 
                }
                if ($i == $j){ 
                    $ass_count++;
                    $s++;
                    $distinctass_arr[$s]['assignment'] = $stmt_arr[$i]['assignment'] ; 
                }
            }
            // for ( $i = 0; $i < $ass_count; $i++){
            //     array_push($ass_list,$distinctass_arr[$i]['assignment']);
            //     // $ass_list[$i]['Number'] = 0;
            // }
            // $assignment[] = ['name', 'Number'];
            // foreach($distinctass_arr as $key => $value){
            //     $assignment[++$key] = [$value->name, $value->Number];
            // }
            $cr = DB::table('assignments')->where('cid',$course)->get();
            $assignment = array();
            foreach ($cr as $key => $value) { 
                $assignment[$value->title]=0; 
            }
            foreach($distinct_arr as $us){
                foreach($assignment as $key => $value){
                    if($key==$us["assignment"]){ $assignment[$key]++; } 
                }
            }
    
        }
        
       
        
        return($assignment);
        // dd($count,$stmt_arr,$crs,$sub_count,$distinct_arr,$distinctass_arr,$ass_count,$assignment,$cr);
    }

    public function quizComp($course)
    {
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $count=0;
        $stmt_arr = array();
        $logArray = array();
        $lgArray = array();
        $distinct_arr = array();
        $notcom_array = array();
        $result = 0;
        $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->object->id);
            if($logArray[sizeof($logArray)-2]==="quiz"){  
                $general=explode("/",$state[$i]->verb->id);
                if($general[sizeof($general)-1]==="completed" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
                    $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ; 
                    $stmt_arr[$count]['quiz'] = $state[$i]->object->definition->name->en;
                    // $stmt_arr[$count]['id'] = $state[$i]->id;
                    $count+=1;
                }
            }
        }
         //get distinct quiz completed users
         $sub_count = 1; 
         $s = 0;
         $quiz = array();

         if($count!=0){
            $distinct_arr[$s]['user'] = $stmt_arr[$s]['user'] ;
            $distinct_arr[$s]['quiz'] = $stmt_arr[$s]['quiz'] ;
            for ( $i = 1; $i < $count; $i++) 
            { 
                for ($j = 0; $j < $i; $j++) {
                    if ($stmt_arr[$i]['user'] == $stmt_arr[$j]['user'] && $stmt_arr[$i]['quiz'] == $stmt_arr[$j]['quiz'] ) 
                       break; 
                }
                if ($i == $j){ 
                    $sub_count++;
                    $s++;
                    $distinct_arr[$s]['user'] = $stmt_arr[$i]['user'] ;
                    $distinct_arr[$s]['quiz'] = $stmt_arr[$i]['quiz'] ; 
                }
            }
           //get distinct completed quiz list
           $quiz_count = 1; 
           $s = 0;
           $distinctquiz_arr[$s]['quiz'] = $stmt_arr[$s]['quiz'] ;
           for ( $i = 1; $i < $count; $i++) 
           { 
               for ($j = 0; $j < $i; $j++) {
                   if ($stmt_arr[$i]['quiz'] == $stmt_arr[$j]['quiz']) 
                      break; 
               }
               if ($i == $j){ 
                   $quiz_count++;
                   $s++;
                   $distinctquiz_arr[$s]['quiz'] = $stmt_arr[$i]['quiz'] ; 
               }
           }
           $cr = DB::table('quiz')->where('cid',$course)->get();
           foreach ($cr as $key => $value) { 
               $quiz[$value->title]=0; 
           }
           foreach($distinct_arr as $us){
               foreach($quiz as $key => $value){
                   if($key==$us["quiz"]){ $quiz[$key]++; } 
               }
           }
         }
        
        return ($quiz);
        // dd($count,$stmt_arr,$distinctquiz_arr,$quiz_count);
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
        //dont we have to change scs3209 to get the subject code automatically?????????????
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
        // dd($cr,$count,$stmt_arr,$assignment,$reg_no);
    }

    
    public function best($course){
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $stmt_arr = array();
        $sum_arr = array();
        $count=0;
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="scored"){
                $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ;
                $stmt_arr[$count]['name'] = $state[$i]->actor->name ;
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
                if($general[sizeof($general)-1]==="completed"){
                    $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ; 
                    $stmt_arr[$count]['name'] = $state[$i]->actor->name ;
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
        //dont we have to change scs3209 to get the subject code automatically?????????????
        $gr = DB::table('stu_enrollments')->where('cid',$course)->get();
        $assignment = array();
        $list = array();
        $bestlist = array();
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
                    $assignment[$key]['name']= $stmt_arr[$i]['name'];
                }
                if($key==$stmt_arr[$i]['user'] && $stmt_arr[$i]['amarks']==0){
                    $assignment[$key]['quizcount']++;
                    $assignment[$key]['quizmax']+=$stmt_arr[$i]['qmax'];
                    $assignment[$key]['quizsum']+= $stmt_arr[$i]['qmarks'];
                    $assignment[$key]['name']= $stmt_arr[$i]['name'];
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
                if($assignment[$key]['assavg']>=60 && $assignment[$key]['quizavg']>=60 ){
                    $list[$key]['assavg']= $assignment[$key]['assavg'];
                    $list[$key]['quizavg']= $assignment[$key]['quizavg'];
                    $list[$key]['name']= $assignment[$key]['name'];
                }
            
        }
        foreach ($list as $key => $row) {
            $assavg[$key]  = $row['assavg'];
            $quizavg[$key] = $row['quizavg'];
        }
        array_multisort($assavg, SORT_ASC, $quizavg, SORT_ASC, $list);
        $bestlist = array_slice($list, 0, 20);

        return ($bestlist);
        // dd($cr,$count,$stmt_arr,$assignment,$list,$bestlist);
    }


}