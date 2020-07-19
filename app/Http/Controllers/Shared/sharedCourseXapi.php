<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Shared\sharedXapi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;

class sharedCourseXapi extends Controller{
    public function getData($course_id){
        $newXapi = New sharedXapi();
        $statements = $newXapi->getData();
        $stmt_count = count($statements);

        $state = array();
        for($i=0;$i<$stmt_count;$i++){
            //$temp = json_decode($statements[$i]->data);
            $temp = $statements[$i];
            // array_push($stmt_arr,$temp);
            $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
            $logArray=explode("/",$temp->verb->id);
                if(isset($temp->object->definition->extensions->$key)){
                    // array_push($stmt_arr,$temp->object->definition->extensions);
                    // if(isset($temp->object->definition->extensions->$key)){
                        // array_push($stmt_arr,$temp->object->definition->extensions);
                        if($temp->object->definition->extensions->$key===$course_id){
                        //     array_push($state,$temp->actor);
                            $state[$i]['user'] = $temp->actor ;
                            $state[$i]['verb'] = $temp->verb->display->en;
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
        return($state) ;
    }
}
