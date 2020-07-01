<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enrollment;

class EnrollmentController extends Controller{
    public function store(Request $request){
        $this->validate($request,[
            'cid' => 'required',
            'index' => 'required',
    
        ]);

        $enrollment = new Enrollment ;
        $enrollment->cid = $request->input('cid');
        $enrollment->index = $request->input('index');
        $enrollment->save();

        return  redirect('/lecturer/lecturer_home');    
    }
}
