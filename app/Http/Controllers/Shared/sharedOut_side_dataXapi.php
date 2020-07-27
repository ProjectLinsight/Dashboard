<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;use App\Http\Controllers\Shared\sharedXapi;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\New_;
use App\User;
use Illuminate\Support\Facades\Auth;

class sharedOut_side_dataXapi extends Controller
{
    public function getData(){
     

        $newXapi = New sharedXapi();
        $statements = $newXapi->getData();
        $stmt_count = count($statements);
        //dd($statements);
        $reg_no =substr(Auth::user()->email,0,9);
        
        $state = array();
        for($i=0;$i<$stmt_count;$i++){
           
            $temp = $statements[$i];
            $key = "https://w3id.org/learning-analytics/learning-management-system/short-id";
            $logArray=explode("/",$temp->verb->id);  
                if(isset($temp->verb->display->en)){
                    
                        if($temp->verb->display->en==="Visited"){
                            if($temp->actor->name=== $reg_no){
                       
                                $state[$i]['user'] = $temp->actor ;
                                $state[$i]['title'] = $temp->object->definition->name->en ;
                                $state[$i]['url'] = $temp->object->definition->description->en ;                            
                                $state[$i]['timestamp'] = $temp->timestamp ;
                            }                   
                        }
                }             
        }
    return($state) ; 
    }
}
