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

    public function edit(\App\User $user){
        // $this->authorize('update',$post);
       
        return view('profile.profile_name_edit',compact('user'));
    }


    public function update(\App\Post $user){
        // $this->authorize('update',$post);
        $data = request()->validate([
            'name' => 'required',
        ]);
       
            auth()->user()->where('id', $user->id)->update([
                'name' => $data['name'],
            ]);   

        return  redirect('/profile/' . auth()->user()->id. '/' . auth()->user()->name);   
    }


}
