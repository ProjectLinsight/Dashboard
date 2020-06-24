<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class xapiDataController extends Controller{
    public function index(){
    $statements = DB::connection('mysql2')->table('trax_xapiserver_statements')->get();
    
    $state = array();
    for($i=0;$i<20;$i++){
        $temp = json_decode($statements[$i]->data);
        $logArray=explode("/",$temp->verb->id);
        if($logArray[sizeof($logArray)-1]==="visited"){
            $state[$i]['location'] = "outside" ;
        }else{
            $state[$i]['location'] = "inside" ;
        }
        $state[$i]['user'] = $temp->actor->account->name ;
        $state[$i]['title'] = $temp->object->definition->name->en ;
        $state[$i]['description'] = $temp->object->definition->description->en ;
        $state[$i]['timestamp'] = $temp->timestamp ;
    }
    return view('analysis.analysis',['xapi'=>$state]);
    
    }
}