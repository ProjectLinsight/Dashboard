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
        $count=0;
        $state = array();
        for($i=0;$i<$stmt_count;$i++){
            //$temp = json_decode($statements[$i]->data);
            $temp = $statements[$i];
            // array_push($stmt_arr,$temp);
            $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
            $logArray=explode("/",$temp->verb->id);
            $objArray=explode("/",$temp->object->id);
                if(isset($temp->object->definition->extensions->$key)){
                    // array_push($stmt_arr,$temp->object->definition->extensions);
                    // if(isset($temp->object->definition->extensions->$key)){
                        // array_push($stmt_arr,$temp->object->definition->extensions);
                        if($temp->object->definition->extensions->$key===$course_id){
                        //     array_push($state,$temp->actor);
                            $state[$count]['user'] = $temp->actor ;
                            $state[$count]['verb'] = $temp->verb->display->en;
                            $state[$count]['title'] = $temp->object->definition->name->en ;
                            $state[$count]['definition'] = $temp->object->definition ;
                            $state[$count]['course'] = $temp->object->definition->extensions->$key ;
                            $state[$count]['timestamp'] = $temp->timestamp ;
                            $state[$count]['type'] = "other";
                            $state[$count]['object'] = $objArray[sizeof($objArray)-2];
                            $start_date = explode("T",$temp->timestamp);
                            $state[$count]['date'] = $start_date[0] ;
                            $count++;
                        // }

                    }
                }
                if(isset($temp->context->contextActivities->grouping[1]->definition->extensions->$key)){
                    if($temp->context->contextActivities->grouping[1]->definition->extensions->$key===$course_id){
                        if($logArray[sizeof($logArray)-1]==="scored"){
                            $state[$count]['user'] = $temp->actor ;
                            $state[$count]['verb'] = $temp->verb->display->en;
                            $state[$count]['title'] = $temp->object->definition->name->en ;
                            $state[$count]['definition'] = $temp->object->definition ;
                            $state[$count]['course'] = $temp->context->contextActivities->grouping[1]->definition->extensions->$key ;
                            $state[$count]['timestamp'] = $temp->timestamp ;
                            $state[$count]['type'] = "assignment";
                            $state[$count]['object'] = $objArray[sizeof($objArray)-2];
                            $state[$count]['marks'] = $temp->result->score->raw ;
                            $state[$count]['maxMarks'] = $temp->result->score->max;
                            $start_date = explode("T",$temp->timestamp);
                            $state[$count]['date'] = $start_date[0] ; 
                            $count++;
                        }
                        else if($objArray[sizeof($objArray)-2]==="quiz" && $logArray[sizeof($logArray)-1]==="completed"){
                            
                            if(isset($temp->result->score->raw)){
                                $state[$count]['user'] = $temp->actor ;
                                $state[$count]['verb'] = $temp->verb->display->en;
                                $state[$count]['title'] = $temp->object->definition->name->en ;
                                $state[$count]['definition'] = $temp->object->definition ;
                                $state[$count]['course'] = $temp->context->contextActivities->grouping[1]->definition->extensions->$key ;
                                $state[$count]['timestamp'] = $temp->timestamp ;
                                $state[$count]['type'] = "quiz";
                                $state[$count]['object'] = $objArray[sizeof($objArray)-2];
                                $state[$count]['marks'] = $temp->result->score->raw ;
                                $state[$count]['maxmarks'] = $temp->result->score->max ;
                                $start_date = explode("T",$temp->timestamp);
                                $state[$count]['date'] = $start_date[0] ; 
                                $count++;
                            }
                            
                        }
                        else{
                            $state[$count]['user'] = $temp->actor ;
                            $state[$count]['verb'] = $temp->verb->display->en;
                            $state[$count]['title'] = $temp->object->definition->name->en ;
                            $state[$count]['definition'] = $temp->object->definition ;
                            $state[$count]['course'] = $temp->context->contextActivities->grouping[1]->definition->extensions->$key ;
                            $state[$count]['timestamp'] = $temp->timestamp ;
                            $state[$count]['type'] = "other";
                            $state[$count]['object'] = $objArray[sizeof($objArray)-2];
                            $start_date = explode("T",$temp->timestamp);
                            $state[$count]['date'] = $start_date[0] ; 
                            $count++;
                        }
                    }
                }

        }
        return($state) ;
    }
}
