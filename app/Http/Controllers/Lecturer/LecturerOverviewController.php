<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
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
        $stmt_arr=$this->assignmentComp();
        $q_arr=$this->quizComp();
        $stat=$this->assignmentStat();
        return view('lecturer/overview',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            ])
            ->with('assignment', json_encode($stmt_arr))
            ->with('quiz', json_encode($q_arr))
            ->with('stats', $stat);
        
    }
   
    public function assignmentStat()
    {
        $data = new sharedXapi();
        $state = $data->getData();
        $stmt_count = count($state);
        $stmt_arr = array();
        $max_arr = array();
        $min_arr = array();
        $min=100;
        $max=0;
        $avg=0;
        $sum=0;
        $count=0;
        $cr = DB::table('assignments')->get();
        $assignment = array();
        foreach ($cr as $key => $value) { 
            $assignment[$value->title]['sum']=0; 
            $assignment[$value->title]['max']=0; 
            $assignment[$value->title]['min']=100; 
            $assignment[$value->title]['avg']=0;
            $assignment[$value->title]['count']=0;  
        }
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="scored"){
                $stmt_arr[$count]['user'] = $state[$i]->actor->account->name ;
                $stmt_arr[$count]['assignment'] = $state[$i]->object->definition->name->en ;
                $stmt_arr[$count]['marks'] = $state[$i]->result->score->raw ;
                $stmt_arr[$count]['group'] = $state[$i]->context->contextActivities->grouping ;
                $sum+=$state[$i]->result->score->raw;
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
        $avg=$sum/$count;

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

    public function assignmentComp()
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
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="submit"){
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
        $cr = DB::table('assignments')->get();
        $assignment = array();
        foreach ($cr as $key => $value) { 
            $assignment[$value->title]=0; 
        }
        // $assignment = array(
        //     'Assignment 1' => 0,
        //     'Assignment 2' => 0,
        //     'Assignment 3' => 0,
        //     'Assignment 4' => 0,
        //     'Assignment 5' => 0,
        //     'Assignment 6' => 0
        //  );
        //  foreach($distinct_arr as $us){
        //     if("Assignment 1"==$us["assignment"]){ $assignment["Assignment 1"]++; }
        //     else if("Assignment 2"==$us["assignment"]){ $assignment["Assignment 2"]++; }
        //     else if("Assignment 3"==$us["assignment"]){ $assignment["Assignment 3"]++; }
        //     else if("Assignment 4"==$us["assignment"]){ $assignment["Assignment 4"]++; }
        //     else if("Assignment 5"==$us["assignment"]){ $assignment["Assignment 5"]++; }
        //     else if("Assignment 6"==$us["assignment"]){ $assignment["Assignment 6"]++; }
        // }
        foreach($distinct_arr as $us){
            foreach($assignment as $key => $value){
                if($key==$us["assignment"]){ $assignment[$key]++; } 
            }
        }

       
        
        return($assignment);
        // dd($count,$stmt_arr,$crs,$sub_count,$distinct_arr,$distinctass_arr,$ass_count,$assignment,$cr);
    }

    public function quizComp()
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
        for($i=0;$i<$stmt_count;$i++){
            $logArray=explode("/",$state[$i]->object->id);
            if($logArray[sizeof($logArray)-2]==="quiz"){  
                $general=explode("/",$state[$i]->verb->id);
                if($general[sizeof($general)-1]==="completed"){
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
        $quiz = array(
            'Quiz 1' => 0,
            'Quiz 2' => 0,
            'Quiz 3' => 0,
            'Quiz 4' => 0,
            'Quiz 5' => 0,
            'IT General Quiz' => 0
         );
         foreach($distinct_arr as $us){
            if("Quiz 1"==$us["quiz"]){ $quiz["Quiz 1"]++; }
            else if("Quiz 2"==$us["quiz"]){ $quiz["Quiz 2"]++; }
            else if("Quiz 3"==$us["quiz"]){ $quiz["Quiz 3"]++; }
            else if("Quiz 4"==$us["quiz"]){ $quiz["Quiz 4"]++; }
            else if("Quiz 5"==$us["quiz"]){ $quiz["Quiz 5"]++; }
            else if("IT General Quiz"==$us["quiz"]){ $quiz["IT General Quiz"]++; }
        }
        
        return ($quiz);
        dd($count,$stmt_arr,$distinctquiz_arr,$quiz_count);
    }

    public function risk(){



    }
}