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
        $min=100;
        $max=0;
        $avg=0;
        $sum=0;
        $count=0;
        for($i=0;$i<$stmt_count;$i++){            
            $logArray=explode("/",$state[$i]->verb->id);
            if($logArray[sizeof($logArray)-1]==="scored"){
                $stmt_arr[$i]['user'] = $state[$i]->actor ;
                $stmt_arr[$i]['assignment'] = $state[$i]->object->definition ;
                $stmt_arr[$i]['marks'] = $state[$i]->result->score->raw ;
                $stmt_arr[$i]['group'] = $state[$i]->context->contextActivities->grouping ;
                $sum+=$state[$i]->result->score->raw;
                $count+=1;
                if($stmt_arr[$i]['marks']>$max){
                    $max=$stmt_arr[$i]['marks'];
                }
                if($stmt_arr[$i]['marks']<$min){
                    $min=$stmt_arr[$i]['marks'];
                }
            }
        }
        $avg=$sum/$count;
        dd($max,$min,$avg,$stmt_arr);
        // $data2 = new sharedCourseXapi();
        // $state2 = $data2->getData();
        // dd($state2);
    }
}