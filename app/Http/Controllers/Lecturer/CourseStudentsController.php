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

class CourseStudentsController extends Controller{
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
        $bestp=$this->best($course);
        return view('lecturer/course_students',[
            'crs'=>$crs[0],
            'stu'=>$stu,
            'enrolled'=>$enrolled,
            ])
            ->with('best', $bestp)
            ->with('user', $user)
            ->with('course',$course);
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

    
    public function best($course){
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
                if($general[sizeof($general)-1]==="completed" && $state[$i]->context->contextActivities->grouping[1]->definition->extensions->$key===$course){
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
            $assignment[$value]['name']='-';
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
            if($assignment[$key]['assavg']<=50 && $assignment[$key]['quizavg']<=50 ){
                $list[$key]['assavg']= $assignment[$key]['assavg'];
                $list[$key]['quizavg']= $assignment[$key]['quizavg'];
                $list[$key]['name']= $assignment[$key]['name'];
                $list[$key]['risklevel']= "High";
            }
            if($assignment[$key]['assavg']>50 && $assignment[$key]['quizavg']<=50 || $assignment[$key]['assavg']<=50 && $assignment[$key]['quizavg']>50){
                $list[$key]['assavg']= $assignment[$key]['assavg'];
                $list[$key]['quizavg']= $assignment[$key]['quizavg'];
                $list[$key]['name']= $assignment[$key]['name'];
                $list[$key]['risklevel']= "Low";
            }
            if($assignment[$key]['assavg']>50 && $assignment[$key]['quizavg']>50 ){
                $list[$key]['assavg']= $assignment[$key]['assavg'];
                $list[$key]['quizavg']= $assignment[$key]['quizavg'];
                $list[$key]['name']= $assignment[$key]['name'];
                $list[$key]['risklevel']= "No";
                }
            
        }
        foreach ($list as $key => $row) {
            $assavg[$key]  = $row['assavg'];
            $quizavg[$key] = $row['quizavg'];
        }
        // array_multisort($assavg, SORT_ASC, $quizavg, SORT_ASC, $list);
        $bestlist = array_slice($list, 0, 20);

        return ($list);
        // dd($cr,$count,$stmt_arr,$assignment,$list,$bestlist);
    }


}