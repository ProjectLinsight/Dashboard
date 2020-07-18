<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use DateTime;
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

        $data = new sharedCourseXapi();
        $cur_course_stmts = $data->getData($course);
        //dd($cur_course_stmts);
        $user_stmts = Array();

        foreach($cur_course_stmts as $st){
            if($st['user']->account->name == $reg_no){
                array_push($user_stmts,$st);
            }
        }
        //dd($user_stmts);

        $activity[] = ['activity', 'Number'];
        $activity = array(
            "Visited" => 0,
            "Viewed" => 0,
            "Started" => 0,
            "Completed" => 0,
            "Submitted" => 0,
            "Graded" => 0,
            "Logged in" => 0,
            "Logged out" => 0,
            "Received" => 0,
            "Created" => 0,
            "Other" => 0,
        );

        foreach($user_stmts as $us){
            if("visited"==$us["verb"]){ $activity["Visited"]++; }
            else if("viewed"==$us["verb"]){ $activity["Viewed"]++; }
            else if("started"==$us["verb"]){ $activity["Started"]++; }
            else if("completed"==$us["verb"]){ $activity["Completed"]++; }
            else if("submitted"==$us["verb"]){ $activity["Submitted"]++; }
            else if("attained grade for"==$us["verb"]){ $activity["Graded"]++; }
            else if("logged into"==$us["verb"]){ $activity["Logged In"]++; }
            else if("logged out of"==$us["verb"]){ $activity["Logged Out"]++; }
            else if("received"==$us["verb"]){ $activity["Received"]++; }
            else if("enrolled to"==$us["verb"]){ $activity["Created"]++; }
            else{ $activity["Other"]++; }
        }

        $verb_counts = array_count_values(array_column($user_stmts, 'verb'));
        $date_counts = array_count_values(array_column($user_stmts, 'date'));
        dd($date_counts);


        $data = DB::table('results')->where('subjectCode',$my_course[0]->cid)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        return view('student.courses.personal',[
            'crs'=> $course_name,
            'counts'=> $verb_counts,])
            ->with('grade', json_encode($array))
            ->with('activity', json_encode($activity))
            ;
    }

    public function datediffInWeeks($date1, $date2)
    {
        $first = DateTime::createFromFormat('Y-m-d', $date1);
        $second = DateTime::createFromFormat('Y-m-d', $date2);
        return floor($first->diff($second)->days/7);
    }
}
