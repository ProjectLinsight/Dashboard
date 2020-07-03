<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Shared\sharedXapi;
use App\Courses ;
use App\User ;

class PersonalCoursesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($course){

        $my_course = DB::table('stu_enrollments')->where('cid',$course)->where('index',Auth::user()->index)->get();
        $course_name = DB::table('courses')->where('cid',$course)->pluck('cName');
        $reg_no = substr(Auth::user()->email,0,9);

        $data = new sharedXapi();
        $statements = $data->getData();
        $my_statements = array();
        
        foreach($statements as $st){
            if($st['user'] == $reg_no){
                array_push($my_statements,$st);
            }
        }
        
        $verb_counts = array_count_values(array_column($my_statements, 'verb'));
        // $log = ($verb_counts['logged-in']);
       
        // dd($verb_counts['logged-in']);
        // $log = ($verb_counts['logged-in']);

        $data = DB::table('results')->where('subjectCode',$my_course[0]->cid)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        return view('courses.personal',[
            'crs'=> $course_name,
            'counts'=> $verb_counts,
            
            ])->with('grade', json_encode($array));
    }
}