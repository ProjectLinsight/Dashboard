<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Courses ;
use App\User ;

class PersonalCoursesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($course){
        $Mycourse = DB::table('courses')->where('cid',$course)->get();
        
        return view('courses.personal',[
            'crs'=> $Mycourse,
            ]);
    }
}