<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Admin
Route::get('/admin/dashboard','Admin\DashboardController@index')->middleware('admin');
Route::post('/admin/assign','Admin\DashboardController@assignLec')->middleware('admin');
Route::get('/admin/courses','Admin\CoursesController@index')->middleware('admin');
Route::post('/admin/courses','Admin\CoursesController@store')->middleware('admin');
Route::get('/admin/courses_delete/{id}','Admin\CoursesController@delete')->middleware('admin');
Route::post('/admin/courses/update','Admin\CoursesController@update')->middleware('admin');
Route::get('/admin/results','Admin\ResultsController@index')->middleware('admin');
Route::post('/admin/results','Admin\ResultsController@store')->middleware('admin');
Route::post('/admin/results/{subjectCode}/{yoe}','Admin\ResultsController@destroy')->middleware('admin');
Route::post('/admin/user','Admin\BulkRegisterController@store')->middleware('admin');
Route::get('/admin/user','Admin\BulkRegisterController@index')->middleware('admin');

//Analysis
Route::get('/admin/analysis','Analysis\xapiDataController@index')->middleware('admin');
Route::get('stock/chart','StockController@chart')->middleware('student');
Route::get('/student/analysis','Analysis\student_dataXapiController@index')->middleware('student');

//Students
Route::get('/home', 'Student\HomeController@index')->name('home')->middleware('student');
Route::get('/mycourses/{user}/{name}', 'Student\MycoursesController@index')->name('mycourses.show')->middleware('student');
//Route::get('//mycourses/{user}/{name}','Student\MycoursesController@index')->middleware('student');
Route::get('/results/{user}/{name}','Student\UserResultsController@index');
Route::get('/results/{cid}','Student\UserResultsController@getResults');
Route::get('/profile/{user}/{name}', 'Student\ProfilesController@index')->name('profile.show')->middleware('student');
route::get('courses','Student\CourseDataController@index')->middleware('student');
route::get('courses/{cid}','Student\CourseLogController@index')->middleware('student');
route::get('Mycourses/{course}','Student\PersonalCoursesController@index')->middleware('auth');

//Uplaoding Content
Route::post('/post','Student\PostsController@store')->middleware('student');
Route::get('/post/{post}/{user_id}/edit','Student\PostsController@edit')->name('post.edit')->middleware('student');
Route::patch('/post/{post}/{user_id}/update','Student\PostsController@update')->name('post.update')->middleware('student');
Route::get('/user/{user_id}/edit','Student\ProfilesController@edit')->name('profile.edit')->middleware('student');
Route::post('/user/update_name/{user_id}','Student\ProfilesController@update')->middleware('student');
Route::post('/user/update_photo/{user_id}','Student\ProfilesController@update1')->middleware('student');

//Lecturer
Route::get('/lecturer/lecturer_home', 'Lecturer\HomeController@index')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/courses', 'Lecturer\LecturerCoursesController@index')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/overview', 'Lecturer\LecturerOverviewController@index')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/{student}/studentrisk', 'Lecturer\StudentRiskController@index')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/{student}/bestperformance', 'Lecturer\BestController@index')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/assignment', 'Lecturer\LecturerOverviewController@assignmentStat')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/test', 'Lecturer\LecturerOverviewController@xapitest')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/note', 'Lecturer\LecturerOverviewController@noteCount')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/assignmentcomplete', 'Lecturer\LecturerOverviewController@assignmentComp')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/quizcomplete', 'Lecturer\LecturerOverviewController@quizComp')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/graph', 'Lecturer\StudentRiskController@graph')->middleware('lecturer');
Route::get('/lecturer/{user}/{course}/link', 'Lecturer\StudentRiskController@getLinks')->middleware('lecturer');
Route::post('/lecturer/{user}/{course}/courses/enroll', 'Lecturer\LecturerCoursesController@enrollStudents')->middleware('lecturer');
Route::post('/lecturer/courses/{course}/update', 'Lecturer\LecturerCoursesController@updateCourse')->middleware('lecturer');
Route::post('/lecturer/courses/{course}/addAssignment', 'Lecturer\LecturerCoursesController@addAssignment')->middleware('lecturer');
Route::post('/lecturer/courses/{course}/addQuiz', 'Lecturer\LecturerCoursesController@addQuiz')->middleware('lecturer');
// Route::post('/lecturer/enrollment', 'Lecturer\EnrollmentController@store')->middleware('lecturer');
//Route::post('/admin/user','Admin\BulkRegisterController@store')->middleware('admin');

Route::get('/student_enrollment' , function(){
    return view('lecturer/student_enrollment');
});
