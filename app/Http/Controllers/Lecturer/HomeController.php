<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\LecturerDetails;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('lecturer/lecturer_home');
    } 

  /*  public function index()
    {
        $user = User::all();
        $lecturer = LecturerDetails::all();

       // return view('lecturer/lecturer_home',compact('user'));
        return view('lecturer/lecturer_home',compact('user','lecturer',));
    } */
}
