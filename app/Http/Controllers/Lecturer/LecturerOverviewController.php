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
        if(substr($course,0,1)=='I'){
            $degree = "Information Systems";
        } else if(substr($course,0,1)=='S'){
            $degree = "Computer Science";
        } 

        $stu = DB::table('users')->where('utype','Student')->where('degree',$degree)->get();
        return view('lecturer/overview',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            ]);
        
    }
    public function enrollStudents(Request $request){
        for($i=0;$i<sizeof($request->enroll);$i++){
            $data = new Stu_enrollment ;
            $data->cid = $request->cid ;
            $data->index = $request->enroll[$i] ;
            $data->flag = true ;
            $data->year = "2020" ;
            $data->save();
        }
    //return view('lecturer/courses');
    return redirect('lecturer/'.auth()->user()->id.'/'.$request->cid.'/courses');
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
        dd($max,$max_arr,$min,$min_arr,$avg,$stmt_arr);
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
        //get distinct values
        $sub_count = 1; 
        $s = 0;
        $distinct_arr[$s]['user'] = $stmt_arr[$s]['user'] ;
        $distinct_arr[$s]['assignment'] = $stmt_arr[$s]['assignment'] ;
        for ( $i = 1; $i < $count; $i++) 
        { 
            for ($j = 0; $j < $i; $j++) {
                if ($stmt_arr[$i]['user'] == $stmt_arr[$j]['user']) 
                   break; 
            }
            if ($i == $j){ 
                $sub_count++;
                $s++;
                $distinct_arr[$s]['user'] = $stmt_arr[$i]['user'] ;
                $distinct_arr[$s]['assignment'] = $stmt_arr[$i]['assignment'] ; 
            }
        }
        
        dd($count,$stmt_arr,$crs,$sub_count,$distinct_arr);
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
                    $stmt_arr[$count]['assignment'] = $state[$i]->object->definition->name->en;
                    $stmt_arr[$count]['id'] = $state[$i]->id;
                    $count+=1;
                }
            }
            //
        }
        
        
        dd($count,$stmt_arr);
    }
}