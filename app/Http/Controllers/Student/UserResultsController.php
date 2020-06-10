<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Results ;
use App\User ;
use App\StudentData ;

class UserResultsController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(User $user){
        $check = Results::where('semester', '1')->where('year','1')->where('index',$user->index)->first();
        if($check!==null){
            $results11 = Results::where('semester', '1')->where('year','1')->where('index',$user->index)->get();
        }
        else{
            $results11 = null ;
        }
        $check = Results::where('semester', '2')->where('year','1')->where('index',$user->index)->first();
        if($check!==null){
            $results12 = Results::where('semester', '2')->where('year','1')->where('index',$user->index)->get();
        }
        else{
            $results12 = null ;
        }
        $check = Results::where('semester', '1')->where('year','2')->where('index',$user->index)->first();
        if($check!==null){
            $results21 = Results::where('semester', '1')->where('year','2')->where('index',$user->index)->get();
        }
        else{
            $results21 = null ;
        }
        $check = Results::where('semester', '2')->where('year','2')->where('index',$user->index)->first();
        if($check!==null){
            $results22 = Results::where('semester', '2')->where('year','2')->where('index',$user->index)->get();
        }
        else{
            $results22 = null ;
        }
        
        $check = Results::where('semester', '1')->where('year','3')->where('index',$user->index)->first();
        if($check!==null){
            $results31 = Results::where('semester', '1')->where('year','3')->where('index',$user->index)->get();
        }
        else{
            $results31 = null ;
        }
        $check = Results::where('semester', '2')->where('year','3')->where('index',$user->index)->first();
        if($check!==null){
            $results32 = Results::where('semester', '2')->where('year','3')->where('index',$user->index)->get();
        }
        else{
            $results32 = null ;
        }
        $check = Results::where('semester', '1')->where('year','4')->where('index',$user->index)->first();
        if($check!==null){
            $results41 = Results::where('semester', '1')->where('year','4')->where('index',$user->index)->get();
        }
        else{
            $results41 = null ;
        }
        $check = Results::where('semester', '2')->where('year','4')->where('index',$user->index)->first();
        if($check!==null){
            $results42 = Results::where('semester', '2')->where('year','4')->where('index',$user->index)->get();
        }
        else{
            $results42 = null ;
        }

        $students = StudentData::all();
        $batch = array();
        $getData = array();
        $gpaData = array();
        $GPA = null ;
        $gp11=null;
        $gp12=null;
        $gp21=null;
        $gp22=null;
        $gp31=null;
        $gp32=null;
        $gp41=null;
        $gp42=null;

        foreach($students as $st){
            if(substr($st->index,0,4)===substr($user->index,0,4)){
                array_push($batch,$st);
                $total = $st->totCredits11 + $st->totCredits12 + $st->totCredits21 + $st->totCredits22 + $st->totCredits31 + $st->totCredits32 + $st->totCredits41 + $st->totCredits42 ;    
                $gp = $st->gpa11 + $st->gpa12 + $st->gpa21 + $st->gpa22 + $st->gpa31 + $st->gpa32 + $st->gpa41 + $st->gpa42 ;    
                if($total!==0.00){$GPA = number_format($gp/$total,4);}
                if($st->totCredits11!==0.00){$gp11 = number_format($st->gpa11 / $st->totCredits11,4);}
                if($st->totCredits12!==0.00){$gp12 = number_format($st->gpa12 / $st->totCredits12,4);}
                if($st->totCredits21!==0.00){$gp21 = number_format($st->gpa21 / $st->totCredits21,4);}
                if($st->totCredits22!==0.00){$gp22 = number_format($st->gpa22 / $st->totCredits22,4);}
                if($st->totCredits31!==0.00){$gp31 = number_format($st->gpa31 / $st->totCredits31,4);}
                if($st->totCredits32!==0.00){$gp32 = number_format($st->gpa32 / $st->totCredits32,4);}
                if($st->totCredits41!==0.00){$gp41 = number_format($st->gpa41 / $st->totCredits41,4);}
                if($st->totCredits42!==0.00){$gp42 = number_format($st->gpa42 / $st->totalCredits42,4);}  
                array_push($gpaData,[
                    'index' => $st->index,
                    'id' => $st->user->id,
                    'name' => $st->user->name,
                    'GPA' => $GPA,
                    'rank' => 0 ,
                    'gp11' =>$gp11,
                    'gp12' =>$gp12,
                    'gp21' =>$gp21,
                    'gp22' =>$gp22,
                    'gp31' =>$gp31,
                    'gp32' =>$gp32,
                    'gp41' =>$gp41,
                    'gp42' =>$gp42,
                    ]);
                if($st->index===$user->index){
                    if ($GPA>=3.70) {
                        $class = "FC";
                        $cl = "First Class";
                    } else if ($GPA>=3.30)  {
                        $class = "SU";
                        $cl = "Second Upper"; 
                    } else if ($GPA>=3.00)  {
                        $class = "SL";
                        $cl = "Second Lower";
                    } else if ($GPA>=2.00)  {
                        $class = "GN";
                        $cl = "General Degree";  
                    } else{
                        $class = "- - ";
                        $cl = "Not Available";  
                    }
                    array_push($getData,[
                        'index' => $st->index,
                        'id' => $st->user->id,
                        'name' => $st->user->name,
                        'credits' => $total,
                        'sclass' => $class,
                        'class' => $cl,
                        'GPA' => $GPA,
                        'rank'=> 0,
                        'gp11' =>$gp11,
                        'rank11' => 0,
                        'gp12' =>$gp12,
                        'rank12' => 0,
                        'gp21' =>$gp21,
                        'rank21' => 0,
                        'gp22' =>$gp22,
                        'rank22' => 0,
                        'gp31' =>$gp31,
                        'rank31' => 0,
                        'gp32' =>$gp32,
                        'rank32' => 0,
                        'gp41' =>$gp41,
                        'rank41' => 0,
                        'gp42' =>$gp42,
                        'rank42' => 0,
                        'results11'=> $results11,
                        'results12'=>$results12,
                        'results21'=>$results21,
                        'results22'=>$results22,
                        'results31'=>$results31,
                        'results32'=>$results32,
                        'results41'=>$results41,
                        'results42'=>$results42,
                        ]);
                }
            }
        }
        function sortByGpa($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }
        function getRank($gpaData,$user,$sem){
            $j=0 ;
            for($i=0;$i<count($gpaData);$i++){  
                if($i!==0 && $gpaData[$i][$sem]===$gpaData[$i-1][$sem]){}
                else{$j=$i+1;}
                if($gpaData[$i]["index"]===$user){
                    return $j ;
                } 
            }   
        }
        usort($gpaData, sortByGpa('gp11'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank11"]= getRank($gpaData,$user->index,'gp11');

        usort($gpaData, sortByGpa('gp12'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank12"]= getRank($gpaData,$user->index,'gp12');

        usort($gpaData, sortByGpa('gp21'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank21"]= getRank($gpaData,$user->index,'gp21');

        usort($gpaData, sortByGpa('gp22'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank22"]= getRank($gpaData,$user->index,'gp22');

        usort($gpaData, sortByGpa('gp31'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank31"]= getRank($gpaData,$user->index,'gp31');

        usort($gpaData, sortByGpa('gp32'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank32"]= getRank($gpaData,$user->index,'gp32');

        usort($gpaData, sortByGpa('gp41'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank41"]= getRank($gpaData,$user->index,'gp41');

        usort($gpaData, sortByGpa('gp42'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank42"]= getRank($gpaData,$user->index,'gp42');

        usort($gpaData, sortByGpa('GPA'));
        $gpaData = array_reverse($gpaData);
        $getData[0]["rank"]= getRank($gpaData,$user->index,'GPA');

        // foreach($gpaData as $dt){
        //     // dd($dt[""]);
        //     $dt["rank"]= getRank($dt,$dt["index"],'GPA');
        // }
                
        return view('results/userResults',[
            'gpaData' => $gpaData,
            'user'=>$user,
            'data'=>$getData[0]
            ]);
    }
}