<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller{
    use AuthenticatesUsers;

    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo(){
        if(Auth::user()->password=='Student'){
            return 'home' ;
        }else if(Auth::user()->utype=='Lecturer'){
            return '/lecturer/lecturer_home' ;
        }else if(Auth::user()->utype=='Admin'){
            return '/admin/dashboard' ;
        }
    }

    //  protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }
}
