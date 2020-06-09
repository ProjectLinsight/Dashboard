<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function store(){
       $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => ''
        ]);
        
       if(request('image')!=null){
           // $imagePath = request('image')->store('uploads'); 
           // dd($imagePath);
           $image = request('image');
           $filename = $image->getClientOriginalName();
           $image->move(public_path('uploads/post'),$filename);
           $imagepath= request('image')->getClientOriginalName();
          
            auth()->user()->posts()->create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $imagepath 
            ]);   
        }else{
            auth()->user()->posts()->create($data);
        }  
        return  redirect('/profile/' . auth()->user()->id. '/' . auth()->user()->name);
    






    }

    public function edit(\App\Post $post){
        // $this->authorize('update',$post);
        return view('posts.edit',compact('post'));
    }

    public function update(\App\Post $post){
        // $this->authorize('update',$post);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => ''
        ]);
        if(request('image')!=null){
            $image = request('image');
            $filename = $image->getClientOriginalName();
            $image->move(public_path('uploads/post'),$filename);
            $imagepath= request('image')->getClientOriginalName();
          
            auth()->user()->posts()->where('id', $post->id)->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $imagepath
            ]);   
        }else {
            auth()->user()->posts()->where('id', $post->id)->update($data); 
        } 
        return  redirect('/profile/' . auth()->user()->id. '/' . auth()->user()->name);   
    }
}