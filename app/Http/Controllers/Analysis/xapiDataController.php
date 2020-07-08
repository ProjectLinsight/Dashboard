<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\Shared\sharedXapi ;

class xapiDataController extends Controller{
    public function index(){
        $data = new sharedXapi();
        $state = $data->getData();
        dd($state);
    return view('analysis.analysis',['xapi'=>$state]);
    }
}