<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\StudentData;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller{
    use RegistersUsers;
    protected $redirectTo = '/admin/user';

    public function __construct(){
        $this->middleware('auth');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'utype' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'year' => '',
            'degree' => '',
            'index' =>'',
        ]);
    }
    public function index(){      
        $users = User::all();
        $us = "hello" ;
        return view('admin.user',['users'=> $us]);
    }

    protected function create(array $data){
        if($data['utype']==="Admin"){
            $deg = null;
            $year = null;
            $index = null ;
        }
        else if($data['utype']==="Student"){
            if(substr($data['email'],4,2)=='is'){
                $deg = 'Information Systems';
            }else{
                $deg = 'Computer Science';
            }
            $index = $data['index'];
            $year =(string) ((int) substr($data['email'],0,4) -1).'/'.substr($data['email'],0,4); 

            $stuData = new StudentData ;
                $stuData->index =  $index;
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
        }
        else{
            $deg = null;
            $year = null;
            $index = null ;             
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'utype' => $data['utype'],
            'password' => Hash::make($data['password']),
            'degree' => $deg ,
            'year' => $year,
            'index' =>  $index,
        ]);        
    }
}
