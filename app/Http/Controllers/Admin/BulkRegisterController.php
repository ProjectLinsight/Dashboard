<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\StudentData;
use Datatables ;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BulkRegisterController extends Controller{
    use RegistersUsers;

    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $users = User::all();
        return view('admin.user',['users'=> $users]);
    }

    public function getdata(){
     $students = User::select('email', 'index');
     return Datatables::of($students)->make(true);
    }

    public function store(Request $request){
        $file = $request->file('users');
        $filename = $file->getClientOriginalName();
        $file->move('users',$filename);
        $filepath = public_path("users/".$filename);
        $readfile = fopen($filepath,"r");

        $importData_arr = array();
        $i = 0;
        $j = 4;
        while (($filedata = fgetcsv($readfile,300,",")) !== FALSE) {
            for ($c=0; $c < $j; $c++) {
                $importData_arr[$i][] = $filedata [$c];
            }
            $i++;
        }
        fclose($readfile);

        foreach($importData_arr as $importData){
            if($importData[1]=='Student'){
                if(substr($importData[0],4,2)=='is'){
                    $deg = 'Information Systems';
                }else{
                    $deg = 'Computer Science';
                }
                $index = $importData[3];
                $year =(string) ((int) substr($importData[0],0,4) -1).'/'.substr($importData[0],0,4);

                $stuData = new StudentData ;
                $stuData->index =  $importData[3];

                $stuData->sub11 = '';
                $stuData->res11 = '';
                $stuData->credits11 = '';
                $stuData->gpa11 = 0;
                $stuData->totCredits11 = 0;
                $stuData->sub12 = '';
                $stuData->res12 = '';
                $stuData->credits12 = '';
                $stuData->gpa12 = 0;
                $stuData->totCredits12 = 0;

                $stuData->sub21 = '';
                $stuData->res21 = '';
                $stuData->credits21 = '';
                $stuData->gpa21 = 0;
                $stuData->totCredits21 = 0;
                $stuData->sub22 = '';
                $stuData->res22 = '';
                $stuData->credits22 = '';
                $stuData->gpa22 = 0;
                $stuData->totCredits22 = 0;

                $stuData->sub31 = '';
                $stuData->res31 = '';
                $stuData->credits31 = '';
                $stuData->gpa31 = 0;
                $stuData->totCredits31 = 0;
                $stuData->sub32 = '';
                $stuData->res32 = '';
                $stuData->credits32 = '';
                $stuData->gpa32 = 0;
                $stuData->totCredits32 = 0;

                $stuData->sub41 = '';
                $stuData->res41 = '';
                $stuData->credits41 = '';
                $stuData->gpa41 = 0;
                $stuData->totCredits41 = 0;
                $stuData->sub42 = '';
                $stuData->res42 = '';
                $stuData->credits42 = '';
                $stuData->gpa42 = 0;
                $stuData->totCredits42 = 0;

                $stuData->save();

            }else if($importData[1]=='Lecturer'){
                $deg = null ;
                $index = null ;
                $year = null ;
            }else{
                $deg = null ;
                $index = null ;
                $year = null ;
            }
                $us = new User ;
                $us->name = 'Anonymous User';
                $us->email = $importData[0];
                $us->utype = $importData[1];
                $us->password = Hash::make($importData[2]);
                $us->year = $year;
                $us->degree = $deg;
                $us->index =  $index;
                $us->save();


            }
        return  redirect('/admin/user');
    }

    public function destroy($user){
        User::where('id', $user)->delete();
        return redirect('/admin/user');
    }
}
