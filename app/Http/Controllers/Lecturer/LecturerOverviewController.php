<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses;
use App\Http\Controllers\Shared\sharedXapi ;
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
    public function assigmentStat()
    {
        $data = new sharedXapi();
        $state = $data->getData();
        $count = count($state);
        
    }
}