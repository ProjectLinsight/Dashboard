<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Results;
use App\StudentData;
use App\Courses;

class ResultsController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $results = Results::all();
        return view('admin.results',['results'=>$results]);
    }

    public function store(Request $request){
        $file = $request->file('result');
        $filename = $file->getClientOriginalName();
        $file->move('results',$filename);
        $filepath = public_path("results/".$filename);
        $readfile = fopen($filepath,"r");

        $importData_arr = array();
        $i = 0;
        $j = 2;
        $Ctr=0;
        while (($filedata = fgetcsv($readfile,300,",")) !== FALSE) {
            if($Ctr==0){
                $batch = $filedata[0];
                $yoe = $filedata[1];
                $subjectCode =  preg_replace("/[^a-zA-Z0-9]/", "", $filedata[2]);
                $semester = $filedata[3];
            }
            else if($Ctr>0){
                for ($c=0; $c < $j; $c++) {
                    $importData_arr[$i][] = $filedata [$c];
                }
                $importData_arr[$i][2] = $subjectCode;
                $importData_arr[$i][3] = $batch;
                $importData_arr[$i][4] = $yoe;
                $importData_arr[$i][5] = $semester;
                $i++;
            }
            $Ctr++;
        }
        fclose($readfile);

        foreach($importData_arr as $importData){
            if(substr($importData[2],0,1)==='I'){
                $year = substr($importData[2],2,1);
            }                
            else if(substr($importData[2],0,1)==='S'){
                 $year = substr($importData[2],3,1);
            }
            $res = new Results ;
            $res->index = $importData[0];
            $res->grade = $importData[1];
            $res->subjectCode = $importData[2];
            $res->batch = $importData[3];
            $res->yoe = $importData[4];
            $res->year = $year ;
            $res->semester = $importData[5];
            $res->save();

            $stuData = StudentData::where('index',$importData[0])->first();
            if($stuData!==null){
                if (substr($importData[2],0,1)==='I'){
                    $year=substr($importData[2],2,1);
                }
                else if(substr($importData[2],0,1)==='S'){
                    $year=substr($importData[2],3,1);
                } 
                else{
                    $year=substr($importData[2],2,1);
                }
                $YearAndSem = $year.$importData[5];
    
                $sub = 'sub'.$YearAndSem;
                $res = 'res'.$YearAndSem;
                $credits = 'credits'.$YearAndSem;
                $tot = 'totCredits'.$YearAndSem;
                $gpa = 'gpa'.$YearAndSem;
    
                $stuData->$sub = $stuData->$sub.','.$importData[2];
                $stuData->$res = $stuData->$res.','.$importData[1];
                $stuData->$credits = $stuData->$credits.','.Courses::where('cid',$importData[2])->first()->credits;
                $TotPts = 0 ;
                $TotCredits = 0 ;
    
                $resArray = explode (",", $stuData->$res);  
                $creditArray = explode (",", $stuData->$credits);
                
                for($i=0; $i<count($resArray); $i++){
                    $TempGrade = $resArray[$i];
                    $TempCredit = (int) $creditArray[$i];
                    if($TempGrade=='A' || $TempGrade=='A+'){
                        $val = 4 ;
                    }else if($TempGrade=='A-'){
                        $val = 3.7 ;
                    }else if($TempGrade=='B+'){
                        $val = 3.3 ;
                    }else if($TempGrade=='B'){
                        $val = 3 ;
                    }else if($TempGrade=='B-'){
                        $val = 2.7 ;
                    }else if($TempGrade=='C+'){
                        $val = 2.3 ;
                    }else if($TempGrade=='C'){
                        $val = 2 ;
                    }else if($TempGrade=='C-'){
                        $val = 1.7 ;
                    }else if($TempGrade=='D+'){
                        $val = 1.3 ;
                    }else if($TempGrade=='D'){
                        $val = 1 ;
                    }else{
                        $val = 0 ;
                    }
                    $TotPts = $TotPts + ($val * $TempCredit) ;
                    $TotCredits = $TotCredits + $TempCredit ;
                }
                $stuData->$tot = $TotCredits;
                $stuData->$gpa = $TotPts;
                $FinalCredit = $stuData->totCredits11 + $stuData->totCredits12  + $stuData->totCredits21 + $stuData->totCredits22 + $stuData->totCredits31 + $stuData->totCredits32 + $stuData->totCredits41 + $stuData->totCredits42 ; 
                $FinalGP = $stuData->gpa11 + $stuData->gpa12 + $stuData->gpa21 + $stuData->gpa22 + $stuData->gpa31 + $stuData->gpa32 + $stuData->gpa41 + $stuData->gpa42 ; 
                // $stuData->GPA = $FinalGP/$FinalCredit ;
                $stuData->save();
            }    
        }
        return  redirect('/admin/results');
    }

    public function destroy($subCode,$yoe){
        Results::where('subjectCode', $subCode)->where('yoe',$yoe)->delete();
        $course = Courses::where('cid',$subCode)->get();
        $stuResults = StudentData::all();

        if($course[0]->semester==="Two"){$sem = "2";}
        else{$sem ="1" ;}
        $year = substr(preg_replace("/[^0-9]/", "", $course[0]->cid),0,1);
        $sub = 'sub'.$year.$sem;
        $res = 'res'.$year.$sem;
        $cre = 'credits'.$year.$sem;
        $totCredits = 'totCredits'.$year.$sem ;
        $gpa = 'gpa'.$year.$sem ;
        if(substr($course[0]->cid,0,1)==="I"){
            $temp = "02";
        }
        elseif(substr($course[0]->cid,0,1)==="S"){
            $temp = "00";
        } 
        else{$temp = "11";}

        $bt =substr( ((string)((int)$yoe - (int)$year)),2,2).$temp ;

        foreach($stuResults as $st){
            if(substr($st->index,0,4)===$bt){
                $subjects = explode(",", $st->$sub);
                $results = explode(",", $st->$res);
                $credits = explode(",", $st->$cre);
                
                for($i=0;$i<count($subjects);$i++){
                    if($subjects[$i]==$subCode){
                        \array_splice($subjects,$i, 1);
                        \array_splice($results,$i, 1);
                        \array_splice($credits,$i, 1);
                    }
                }
                $subArray = implode(",",$subjects);
                $resArray = implode(",",$results);
                $creArray = implode(",",$credits);
                
                $TotPts = 0 ;
                $TotCredits = 0 ;
                for($i=0; $i<count($results); $i++){
                    $TempGrade = $results[$i];
                    $TempCredit = (int) $credits[$i];
                    if($TempGrade=='A' || $TempGrade=='A+'){
                        $val = 4 ;
                    }else if($TempGrade=='A-'){
                        $val = 3.7 ;
                    }else if($TempGrade=='B+'){
                        $val = 3.3 ;
                    }else if($TempGrade=='B'){
                        $val = 3 ;
                    }else if($TempGrade=='B-'){
                        $val = 2.7 ;
                    }else if($TempGrade=='C+'){
                        $val = 2.3 ;
                    }else if($TempGrade=='C'){
                        $val = 2 ;
                    }else if($TempGrade=='C-'){
                        $val = 1.7 ;
                    }else if($TempGrade=='D+'){
                        $val = 1.3 ;
                    }else if($TempGrade=='D'){
                        $val = 1 ;
                    }else{
                        $val = 0 ;
                    }
                    $TotPts = $TotPts + ($val * $TempCredit) ;
                    $TotCredits = $TotCredits + $TempCredit ;
                }

                DB::table('student_data')->where('index', $st->index)->update([
                    $totCredits => $TotCredits,
                    $gpa => $TotPts,
                    $sub => $subArray,
                    $res => $resArray,
                    $cre => $creArray,
                    ]);
            }
        }
        return view('/admin/results');
    }
}
