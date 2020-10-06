<?php

namespace App\Http\Controllers\Student;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;

class ProfilesController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(\App\User $user){        
        return view('student.profile.profile',compact('user'));
    }

    public function edit(\App\User $user){
        // $this->authorize('update',$post);
       
        return view('student.profile.profile_name_edit',compact('user'));
    }


    public function update(Request $request,$id){
        $this -> validate($request,[
            'name' =>'required|min:3|max:50|string',
        ]);
            $user = User::find(Auth::user()->id);
            $user->name= $request->get('name');  
            $user->save();

        return  redirect('/home');  
    }



    

  /*  public function update2(Request $request,$id){
       
       
            $user = User::find(Auth::user()->id);

            if( $request-> has('image_path')){
                $image=$request->file('image_path');
                $filename = $image->getClientOriginalName();
                $image->move(public_path('images/tourist'),$filename);
                $user->image_path=$request->file('image_path')->getClientOriginalName();
            }
            
            $user->save();

        return  redirect('/home');  

    } */

    public function update1(Request $request,$id){
       
        $user = User::find(Auth::user()->id);

       // dd($user->image);
       if(request('image')!=null){
            $image = request('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('uploads/photos'),$filename);
            $user->image= request('image')->getClientOriginalName();
        }
        // dd($user->image);
        $user->save();
           
        
         /*   if(request('image')!=null){
                $image = request('image');
                $filename = $image->getClientOriginalName();
                $image->move(public_path('uploads/post'),$filename);
                $imagepath= request('image')->getClientOriginalName();
              
                auth()->user()->posts()->where('id', $post->id)->update([
                    'image' => $imagepath
                ]);   
            } */
           
            return  redirect('/home');   
   
    }

  /*  public function reset_password(Request $request,$id){
        $this -> validate($request,[
            'old_password' => ['required', 'string', 'min:8', ],
            'new_password' => ['required', 'string', 'min:8', ],
            're_password' => ['required', 'string', 'min:8','same:new_password'],

          

        ]);

        if(Hash::check($old_password, $user->password)) {
        

            $user = User::find(Auth::user()->id);
            $user->password= $request->get('new_password');  
            $user->save(); 
            return  redirect('/home')->with('alert', 'Password Updated!');

        } else {
           
            return  redirect('/home')->with('alert', 'Failed to Update!');
        }
            

        return  redirect('/home');  
    }   */

   /* public function sendEmail(Request $request,$id)
    {
        $user = User::find(Auth::user()->id);
        $credentials =  $user->email;
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }  */


}