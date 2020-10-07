<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses ;
use App\User ;
use App\Stu_enrollment;


class CourseLogController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($crs){   
        $log = Courses::where('cid',$crs)->get();

        $user = User::find(Auth::user()->id);
        $enrolled = DB::table('stu_enrollments')->where('index',$user->index)->get();
        $my_course = DB::table('stu_enrollments')->where('cid',$crs)->where('index',Auth::user()->index)->get();

       // dd($enrolled);
       // dd($crs);
        $enrolledSubjects =  sizeof($enrolled);
        $ctr = 0 ;
         foreach($enrolled as $er){
            if (!$er->cid == $crs) {
                $ctr++;  
            }
         } 
         if($enrolledSubjects == $ctr){
             abort(403);
         }  
    
          
        
        // if(substr($log[0]->cid,0,1)=='I'){
        //     if(substr($log[0]->type,0,2)=='Op'){
        //         $string = "Optional" ;
        //     }else if(substr($log[0]->type,0,2)=='Co'){
        //         $string = "Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,3,1)=='X' ){
        //         $string = "IS Hons : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,3,1)=='1' ){
        //         $string = "IS Gen : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,3,1)=='X' ){
        //         $string = "IS Hons : Optional" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,3,1)=='0' ){
        //         $string = "IS Gen : Optional" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,3,1)=='0' ){
        //         $string = "IS Hons : Compulsory / IS Gen : Optional " ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,3,1)=='1' ){
        //         $string = "IS Gen : Compulsory / IS Hons : Optional " ;
        //     }
        // }
        // else if(substr($log[0]->cid,0,1)=='S'){
        //     if(substr($log[0]->type,0,2)=='Op'){
        //         $string = "Optional" ; 
        //     }else if(substr($log[0]->type,0,2)=='Co'){
        //         $string = "Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,3,1)=='X' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "CS Hons : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "SE Hons : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,3,1)=='X' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Gen : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,3,1)=='X' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "CS Hons : Optional" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "SE Hons : Optional" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,3,1)=='X' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "CS Gen : Optional" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "CS Hons & SE Hons : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='X' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Hons & CS Gen : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "SE Hons & CS Gen : Compulsory" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "CS Hons & SE Hons : Compulsory / CS Gen : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Hons & CS Gen : Compulsory / SE Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "SE Hons & CS Gen : Compulsory / CS Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "CS Hons : Compulsory / SE Hons & CS Gen : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "SE Hons : Compulsory / CS Hons & CS Gen : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Gen : Compulsory / CS Hons & SE Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "SE Hons : Compulsory / CS Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,2,1)=='1' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "SE Hons : Compulsory / CS Gen : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='X' ){
        //         $string = "CS Hons : Compulsory / SE Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='1' && substr($log[0]->type,2,1)=='X' && substr($log[0]->type,4,1)=='0' ){
        //         $string = "CS Hons : Compulsory / CS Gen : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='0' && substr($log[0]->type,2,1)=='X' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Gen : Compulsory / CS Hons : Opt" ;
        //     }else if(substr($log[0]->type,2,1)=='X' && substr($log[0]->type,2,1)=='0' && substr($log[0]->type,4,1)=='1' ){
        //         $string = "CS Gen : Compulsory / SE Hons : Opt" ;
        //     }                
        // }
        // else{
        //     $string = "Compulsory of all";
        // }

        $Mycourse = DB::table('courses')->where('cid',$crs)->get();
        $data = DB::table('results')->where('subjectCode',$Mycourse[0]->cid)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }

        return view('student.courses.courseLog',[
            'log'=> $log[0],
            ])->with('grade', json_encode($array));

        }
    
}
