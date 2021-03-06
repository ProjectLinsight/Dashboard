<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses;
use App\AssignLecturer;

class DashboardController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(\App\User $user){
        $lec = DB::table('users')->where('utype','lecturer')->get();

        $courses = Courses::all();

        $suffix = '@ucsc.cmb.ac.lk';

        $assigned_lec = DB::table('assign_lecturers')
                            ->join('courses','assign_lecturers.cid','=','courses.cid')
                            ->select('assign_lecturers.cid', 'assign_lecturers.lid','assign_lecturers.year','courses.cName')->get()->toArray();


        foreach($assigned_lec as $al){
            $lec_email = $al->lid.'@ucsc.cmb.ac.lk';
            $lec_name = DB::table('users')->where('email','=',$lec_email)->value('name');
            $al->lecturer_name = $lec_name;
        }

        //dd($assigned_lec);

        $is1 = array();
        $is2 = array();
        $is3 = array();
        $is4 = array();
        $cs1 = array();
        $cs2 = array();
        $cs3 = array();
        $cs4 = array();

        foreach($courses as $crs){
            if($crs->type==="Compulsory"){
                $crs->type="XXX" ;
            }
            else if($crs->type==="Optional"){
                $crs->type="000" ;
            }
            else{
                $crs->type = str_replace("X","-",$crs->type);
                $crs->type = str_replace("1","X",$crs->type);
                $crs->type = substr($crs->type,2,3);
            }

            if(substr($crs->cid,0,1)==="I"){
                if(substr($crs->cid,2,1)==="1"){
                    array_push($is1,$crs);
                }else if(substr($crs->cid,2,1)==="2"){
                    array_push($is2,$crs);
                }else if(substr($crs->cid,2,1)==="3"){
                    array_push($is3,$crs);
                }else if(substr($crs->cid,2,1)==="4"){
                    array_push($is4,$crs);
                }
            }
            else if(substr($crs->cid,0,1)==="S"){
                if(substr($crs->cid,3,1)==="1"){
                    array_push($cs1,$crs);
                }else if(substr($crs->cid,3,1)==="2"){
                    array_push($cs2,$crs);
                }else if(substr($crs->cid,3,1)==="3"){
                    array_push($cs3,$crs);
                }else if(substr($crs->cid,3,1)==="4"){
                    array_push($cs4,$crs);
                }
            }
        }

        return view('admin.dashboard',[
            'is1'=> $is1,
            'is2'=> $is2,
            'is3'=> $is3,
            'is4'=> $is4,
            'cs1'=> $cs1,
            'cs2'=> $cs2,
            'cs3'=> $cs3,
            'cs4'=> $cs4,
            'lec'=> $lec,
            'assigned_lecturers'=>$assigned_lec
            ]);
    }

    public function assignLec(Request $request){
        $assign = new AssignLecturer ;
        $assign->cid = $request->input('cid');
        $assign->lid = $request->input('lid');
        $assign->year = $request->input('year');
        $assign->startDate = $request->input('sDate');
        $assign->save();

        return  redirect('/admin/dashboard');
    }
}
