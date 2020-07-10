<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses;
use App\LecturerAssigning;

class CoursesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $courses = Courses::all();

        $is1 = array();
        $is2 = array();
        $is3 = array();
        $is4 = array();
        $cs1 = array();
        $cs2 = array();
        $cs3 = array();
        $cs4 = array();

        $courseType[] = ['course', 'type'];
        foreach($courses as $crs){
            $courseType[$crs->cName]=$crs->type;
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
        // dd($courseType);
        return view('/admin/courses',[
            'is1'=> $is1,
            'is2'=> $is2,
            'is3'=> $is3,
            'is4'=> $is4,
            'cs1'=> $cs1,
            'cs2'=> $cs2,
            'cs3'=> $cs3,
            'cs4'=> $cs4,
            ])->with('courseType', json_encode($courseType));;
    }

    public function store(Request $request){
        $this->validate($request,[
            'cid' => 'required',
            'cName' => 'required',
            'credits' => 'required',
            'type' => 'required',
            'semester' => 'required'
        ]);
        $course = new Courses ;
        $course->cid = $request->input('cid');
        $course->cName = $request->input('cName');
        $course->credits = $request->input('credits');
        $course->type = $request->input('type');
        $course->semester = $request->input('semester');
        $course->save();

        return  redirect('/admin/courses');    
    }

    public function store2(Request $request){
        $this->validate($request,[
            'cid' => 'required',
            'lid' => 'required',
            
        ]);
        $assign = new LecturerAssigning ;
        $assign->cid = $request->input('cid');
        $assign->lid = $request->input('lid');
        $assign->save();

        return  redirect('/admin/courses');    
    }

    public function delete($id){ 
        DB::table('courses')->where('cid',$id)->delete();
        return redirect ('/admin/courses')->with('success','Course Deleted');
        
    }

    public function update(Request $request){
        // $this->validate($request,[
           
        //     'credits' => 'required',
        //     'type' => 'required',
        //     'semester' => 'required'
        // ]);
        $course = Courses::where('cid',$request->get('updatecid'))
          ->update([
            'cid' => $request->get('updatecid'),
            'cName' => $request->get('updatecName'),
            'credits' => $request->get('updatecredits'),
            'type' => $request->get('updatetype'),
            'semester' => $request->get('updatesemester')
            ]);

        return  redirect('/admin/courses')->with('success','Data Updated');    
    }


}
