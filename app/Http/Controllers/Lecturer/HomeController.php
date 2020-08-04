<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\LecturerDetails;
use App\Http\Controllers\Shared\sharedCourseXapi ;
use App\Http\Controllers\Shared\sharedXapi ;



class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

        $reg_no = substr(Auth::user()->email,0,9);
        $my_enrolled_courses= DB::table('assign_lecturers')->select('cid')->where('lid',Auth::user()->index)->get()->toArray();
        $enrolled_courses = Array();
        $enrolled_courses_xapi = Array();
        foreach($my_enrolled_courses as $en){
            $temp = $en->cid;
            array_push($enrolled_courses,$temp);
        }

        $data = new sharedCourseXapi();
        foreach($enrolled_courses as $ec){
            $cur_course_stmts = $data->getData($ec);
            $cur_course_count = count($cur_course_stmts);
            $enrolled_courses_xapi[$ec] = $cur_course_count;

            ${"$ec"} = Array();
            $startDate = (DB::table('assign_lecturers')->where('cid',$ec)->first())->startDate;
            $startWeek = date("oW", strtotime($startDate));

            for($i=1;$i<16;$i++){
                ${"$ec"}[$i]= 0 ;
            }
            foreach($data->getData($ec) as $dt){
                $weekNum = intval(date("oW",strtotime($dt["date"]))) - intval(date("oW", strtotime($startDate))) + 1;
                ${"$ec"}[$weekNum]++;
            }
        }

        // $activityNested[] = ['course', 'arr'];
        foreach($enrolled_courses as $ec){
            $activityNested["$ec"] = ${"$ec"} ;
        }
        //dd($activityNested);

        //Assignemt Reminders 

        $all_assignments = Array();
        foreach($enrolled_courses as $subject){
            $subject_assignments = DB::table('assignments')->where('cid',$subject)->get('title')->toArray();
            $gr = DB::table('stu_enrollments')->where('cid',$subject)->get();
            if(count($subject_assignments)>0){
                foreach($subject_assignments as $st){
                    $st->enrolled=count($gr);
                    $st->submitted=0;
                    $st->graded=0;
                }
                $all_assignments[$subject] = $subject_assignments;
            }
        }
        // dd($all_assignments);

        

        $enrolled_xapi = Array();
        $xapi_data = new sharedCourseXapi();
        foreach($enrolled_courses as $ec){
            $cur_course_stmts = $xapi_data->getData($ec);
            foreach($cur_course_stmts as $st){
                foreach($all_assignments[$ec] as $stmt){
                    if($st['verb']==="submitted" && $stmt->title===$st['title']){
                        $stmt->submitted++;
                    }
                    if($st['verb']==="attained grade for" && $stmt->title===$st['title']){
                        $stmt->graded++;
                    }
                }
            }
        }

        // dd($all_assignments);

        
        foreach($all_assignments as $assignment=>$assignment_data){
                
                    foreach($assignment_data as $ad){
                
                            
                            if($ad->graded == $ad->submitted){
                                $ad->flag='completed';
                            }
                            else{
                                $ad->flag='pending';
                            }
                            
                        
                        
                    }
                
            
        }

        // dd($all_assignments);


        //dd($enrolled_qxapi);

        $risk_students = array();
        foreach($enrolled_courses as $subject){
            $ct = $this->risk($subject);
            $risk_students[$subject]=0;
            foreach($ct as $stmt){
                if($stmt['risklevel']!='No'){
                    $risk_students[$subject]++;
                }
            }
        }
        // dd($risk_students);

        

        return view('lecturer/lecturer_home')
            ->with('activityCount', json_encode($enrolled_courses_xapi))
            ->with('activityOverall', json_encode($activityNested))
            ->with('assignment',$all_assignments)
            ->with('risk',json_encode($risk_students))
        ;
    } 

  /*  public function index()
    {
        $user = User::all();
        $lecturer = LecturerDetails::all();

       // return view('lecturer/lecturer_home',compact('user'));
        return view('lecturer/lecturer_home',compact('user','lecturer',));
    } */

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
    }
}
