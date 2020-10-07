<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses;
use App\Stu_enrollment;
use App\Assignments;
use App\Quiz;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAssignment;
use App\User;

class LecturerCoursesController extends Controller{

    public function index($user,$course){
        $crs = DB::table('courses')->where('cid',$course)->get();
        if(substr($course,0,1)=='I'){
            $degree = "Information Systems";
        } else if(substr($course,0,1)=='S'){
            $degree = "Computer Science";
        }

        // url check
        $cr = DB::table('users')->where('id',$user)->get();
        foreach ($cr as $key => $value) {
                    $reg=explode("@",$value->email);
                    $reg_no= $reg[0];

        }
        $enrolled = DB::table('assign_lecturers')->where('lid',$reg_no)->get();
        $course_name  = Courses::where('cid',$course)->get();
        

        // Check the student is enrolled with that course
        $enrolledSubjects =  sizeof($enrolled);
        $ctr = 0 ;
         foreach($enrolled as $er){            
            if ($er->cid != $course) {
                $ctr++;  
            }
         } 
         if($enrolledSubjects == $ctr){
             abort(403);  //show forbiden error
         } 
         
        $stu = DB::table('users')->where('utype','Student')->where('degree',$degree)->get();
        $ent =  DB::table('stu_enrollments')->where('cid',$course)->get();
        $stuNew = array();
        $stuEn = array();
        for($i=0;$i<sizeof($stu);$i++){
            $flag = 1 ;
            for($j=0;$j<sizeof($ent);$j++){
                if($stu[$i]->index===$ent[$j]->index){
                    $flag=0;
                }
            }
            if($flag==1){
                array_push($stuNew,$stu[$i]);
            }else{
                array_push($stuEn,$stu[$i]);
            }
        }

        return view('lecturer/courses',[
            'crs'=>$crs[0],
            'stu'=>$stuNew,
            'stuEn'=>$stuEn,
            // 'ent'=>$ent,
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

    public function updateCourse(Request $request,$course){
        $course = Courses::where('cid',$course)
          ->update([
            'assignmentMarks' => $request->get('aMarks'),
            'examMarks' => $request->get('eMarks'),
            'preRequisites' => $request->get('preRequisites'),
            'introduction' => $request->get('introduction'),
            ]);

        return redirect('lecturer/'.auth()->user()->id.'/'.$course.'/courses');
    }

    public function addAssignment(Request $request,$course){
        $assignment = new Assignments ;
        $assignment->cid = $request->get('cid');
        $assignment->title = $request->get('assignmentTitle');
        $assignment->weight = $request->get('aWeight');
        $assignment->dueDate = $request->get('dueDate');
        $assignment->maxMarks = $request->get('maxMarks');
        $assignment->save();
        // alert("Assignment added successfully!");

        //Notifications
        //$enrolled_students = DB::table('stu_enrollments')->where('cid',$course)->get('index');


        //dd($enrolled_students);
        // foreach($enrolled_students as $student){
        //     $user = User::where('index',$student->index);
        //     dd($user);
        //     Notification::send($user, new NewAssignment($assignment));
        // }

        // dd('done');


        return redirect('lecturer/'.auth()->user()->id.'/'.$course.'/courses');
    }

    public function addQuiz(Request $request,$course){
        $quiz = new Quiz ;
        $quiz->cid = $request->get('cid');
        $quiz->title = $request->get('quizTitle');
        $quiz->dueDate = $request->get('dueDate');
        $quiz->maxMarks = $request->get('maxMarks');
        $quiz->save();
        // alert("Quiz added successfully!");
        return redirect('lecturer/'.auth()->user()->id.'/'.$course.'/courses');
    }
}
