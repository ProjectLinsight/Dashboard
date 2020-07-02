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
        
        $data = DB::table('results')->where('subjectCode',$Mycourse[0]->cid)->select(
                DB::raw('grade as grade'),
                DB::raw('count(*) as number'))
            ->groupBy('grade')->get();

        $array[] = ['grade', 'Number'];
        foreach($data as $key => $value){
            $array[++$key] = [$value->grade, $value->number];
        }
        
        return view('courses.personal',[
            'crs'=> $Mycourse,
            ])->with('grade', json_encode($array));
    }
}