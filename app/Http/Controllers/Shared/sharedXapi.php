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
        }
        return($stmt_arr) ;
    }
}
