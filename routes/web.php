<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Admin 
Route::get('/admin/dashboard','Admin\DashboardController@index')->middleware('admin');
Route::get('/admin/courses','Admin\CoursesController@index')->middleware('admin');
Route::post('/admin/courses','Admin\CoursesController@store')->middleware('admin');
Route::get('/admin/results','Admin\ResultsController@index')->middleware('admin');
Route::post('/admin/results','Admin\ResultsController@store')->middleware('admin');
Route::post('/admin/results/{subjectCode}/{yoe}','Admin\ResultsController@destroy')->middleware('admin');
Route::post('/admin/user','Admin\BulkRegisterController@store')->middleware('admin');
Route::get('/admin/user','Admin\BulkRegisterController@index')->middleware('admin');
// Route::get('/admin/user',['uses'=>'Admin\BulkRegisterController@index', 'as'=>'users.index']);

//Students
Route::get('/home', 'Student\HomeController@index')->name('home')->middleware('student');
Route::get('/mycourses/{user}/{name}', 'Student\MycoursesController@index')->name('mycourses.show')->middleware('student');
//Route::get('//mycourses/{user}/{name}','Student\MycoursesController@index')->middleware('student');
Route::get('/results/{user}/{name}','Student\UserResultsController@index');
Route::get('/profile/{user}/{name}', 'Student\ProfilesController@index')->name('profile.show')->middleware('student');
route::get('courses','Student\CourseDataController@index')->middleware('student');
route::get('courses/{cid}','Student\CourseLogController@index')->middleware('student');


//Uplaoding Content
Route::post('/post','Student\PostsController@store')->middleware('student');
Route::get('/post/{post}/{user_id}/edit','Student\PostsController@edit')->name('post.edit')->middleware('student');
Route::patch('/post/{post}/{user_id}/update','Student\PostsController@update')->name('post.update')->middleware('student');
Route::get('/user/{user_id}/edit','Student\ProfilesController@edit')->name('profile.edit')->middleware('student');
Route::patch('/user/{user_id}/update','Student\ProfilesController@update')->name('profile.update')->middleware('student');

//Lecturer
Route::get('/lecturer/lecturer_home', 'Lecturer\HomeController@index')->middleware('lecturer');

Route::get('/student_enrollment' , function(){
    return view('lecturer/student_enrollment');
});