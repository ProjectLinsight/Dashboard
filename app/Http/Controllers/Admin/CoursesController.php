<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Courses;

class CoursesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data = Courses::all();
        return view('/admin/courses',['data'=> $data]);
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
}
