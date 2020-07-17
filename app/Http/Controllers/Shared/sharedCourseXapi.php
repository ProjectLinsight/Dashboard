<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class sharedCourseXapi extends Controller{
    public function getData(){
        $statements = DB::connection('mysql2')->table('trax_xapiserver_statements')->get();
        //$stmt_json = json_encode($statements);
        $stmt_count = count($statements);
        
        $stmt_arr = array();
        $state = array();
        for($i=0;$i<$stmt_count;$i++){
            $temp = json_decode($statements[$i]->data);
            // array_push($stmt_arr,$temp);
            $key = "https://w3id.org/learning-analytics/learning-management-system/external-id";
            $logArray=explode("/",$temp->verb->id);  
                if(isset($temp->object->definition->extensions->$key)){
                    // array_push($stmt_arr,$temp->object->definition->extensions);
                    // if(isset($temp->object->definition->extensions->$key)){
                        // array_push($stmt_arr,$temp->object->definition->extensions);
                        if($temp->object->definition->extensions->$key==="SCS3109"){
                        //     array_push($state,$temp->actor); 
                            $state[$i]['user'] = $temp->actor ;
                            $state[$i]['title'] = $temp->object->definition->name->en ;
                            $state[$i]['definition'] = $temp->object->definition ;
                            $state[$i]['course'] = $temp->object->definition->extensions->$key ;
                            $state[$i]['timestamp'] = $temp->timestamp ;
                        // }
                        
                    }
                } 
                // $logArray=explode("/",$temp->verb->id);
            // if( $stmt_arr[]==="SCS3109"){
            //     $stmt_arr[$i]['user'] = $state[$i]->actor ;
                
            // }
            // $state[$i]['user'] = $temp->actor ;
            // $state[$i]['title'] = $temp->object->definition->name->en ;
            // $state[$i]['definition'] = $temp->object->definition ;
            // $state[$i]['timestamp'] = $temp->timestamp ;
            
        }
        dd($state);
        return($state) ;
    }
}