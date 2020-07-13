<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sharedXapi extends Controller{
    public function getData(){
        $statements = DB::connection('mysql2')->table('trax_xapiserver_statements')->get();
        //$stmt_json = json_encode($statements);
        $stmt_count = count($statements);
        
        $stmt_arr = array();
        for($i=0;$i<$stmt_count;$i++){
            $temp = json_decode($statements[$i]->data);
            array_push($stmt_arr,$temp);
            
            // $logArray=explode("/",$temp->verb->id);
            // if($logArray[sizeof($logArray)-1]==="visited"){
            //     $state[$i]['location'] = "outside" ;
            //     $state[$i]['verb'] = $logArray[sizeof($logArray)-1];
            // }else{
            //     $state[$i]['location'] = "inside" ;
            //     $state[$i]['verb'] = $logArray[sizeof($logArray)-1];
            // }
            // $state[$i]['user'] = $temp->actor ;
            // $state[$i]['title'] = $temp->object->definition->name->en ;
            // $state[$i]['definition'] = $temp->object->definition ;
            // $state[$i]['timestamp'] = $temp->timestamp ;
        }
        dd($stmt_arr) ;
    }
}