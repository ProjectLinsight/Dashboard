<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(\App\User $user){        
        return view('profile.profile',compact('user'));
    }
}
