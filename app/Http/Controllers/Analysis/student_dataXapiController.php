<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\Shared\sharedXapi;
use App\Http\Controllers\Shared\sharedOut_side_dataXapi ;

class student_dataXapiController extends Controller
{
    public function index(){
        $data = new sharedOut_side_dataXapi();
        $state = $data->getData();
        //dd($state);

    return view('student.analysis.student_analysis',['xapi'=>$state]);
    }

}
