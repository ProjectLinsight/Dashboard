<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class xapiDataController extends Controller{
    public function index(){
    $statements = DB::connection('mysql2')->table('trax_xapiserver_statements')->get();
    
    $obj = json_decode($statements[0]->data);
    dd($obj);
    return view('analysis.analysis',[
        'statements'=> $statements,
    ]);
    }
}
