@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>

@section('content')
<div class="container-fluid pt-4">
    <div id="wrapper" class="wrapper-content" >
        <div id="sidebar-wrapper" class="bg-dark">
            <ul class="sidebar-nav">
                <li class="sidebar-brand pl-0">
                    <h6>{{Auth::user()->email}}<h6>
                </li>
                <li class="pt-3">
                    <a href="/lecturer/lecturer_home"><i class="fas fa-home pr-2"></i>Feed</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a data-toggle="collapse" href="#courses" ><i class="fas fa-user pr-2"></i>Courses</a>
                    <div class="collapse pt-3 pl-5" id="courses">
                        @foreach (Auth::user()->lecAssigning as $item)
                            <h6 class="text-white">
                                <a data-toggle="collapse" href="#{{$item->cid}}"  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">{{$item->cid}}</a>
                            </h6>
                            <div class="collapse pt-0 pl-3" id="{{$item->cid}}">
                                <h6 class="text-white"> <a href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">Update</a></h6>
                                <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Analytics</a></h6>
                                <!-- <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Assignment & Quiz</a></h6> -->
                            </div>
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                <a href="/profile/{{Auth::user()->id}}/{{Auth::user()->name}}"><i class="fas fa-user pr-2"></i>Profile</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student_enrollment"><i class="fas fa-id-card pr-2"></i>Student Entrollment</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>

            </ul>
        </div>

        <div id="page-content-wrapper">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button class="btn-lg btn btn-toggle-menu bg-dark" type="button" style="margin-left:-70px;margin-top:-10px;position:fixed">
                            <i class="text-white fa fa-bars"></i>
                        </button>
                    </div>
                </div>
            </nav>

            <div class="container-fluid m-0"  >
                <hr>
                <h1 class="text-center">{{$crs->cName}}</h1>
                <hr>

                <div class="row">
                    <div class="col-md-8">
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-0">
                                    <h4 class="text-white text-center"> Course Information </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/lecturer/courses/{{$crs->cid}}/update" enctype="multipart/form-data">
                                        @csrf

                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" style="border-collapse: collapse;">
                                                <tbody  style="font-size: calc(0.7em + 0.2vw)">
                                                    <tr>
                                                        <td class="border"> Course Code </td>
                                                        <td class="border" colspan="3"><strong>{{$crs->cid}} </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Course Name </td>
                                                        <td class="border" colspan="3"><strong>{{$crs->cName}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Year </td>
                                                        <td class="border"><strong>{{substr(preg_replace("/[^0-9]/","",$crs->cid),0,1)}}</strong></td>
                                                        <td class="border"> Semester </td>
                                                        <td class="border"><strong>{{$crs->semester}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Course Credits </td>
                                                        <td class="border" colspan="3"><strong>{{$crs->credits}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Formative Assessment </td>
                                                        <td class="border">
                                                            <input required min="0" max="100" id="aMarks" type="number" class="form-control" name="aMarks" value="{{$crs->assignmentMarks}}"  >
                                                        </td>
                                                        <td class="border"> Summative Assessment </td>
                                                        <td class="border">
                                                            <input required min="0" max="100" id="eMarks" type="number" class="form-control" name="eMarks" value="{{$crs->examMarks}}"  >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Pre-requisities </td>
                                                        <td class="border" colspan="3">
                                                            <input required id="preRequisites" type="text" class="form-control" name="preRequisites" value="{{$crs->prerequisites}}"  >
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="border"> Introduction </td>
                                                        <td class="border text-justify" colspan="2">
                                                            <input required id="introduction" type="text" class="form-control" name="introduction" value="{{$crs->introduction}}"  >
                                                        </td>
                                                        <td class="text-justify">
                                                            <div class="form-group d-flex justify-content-center">
                                                                <button type="submit" class="btn btn-info btn-block text-white">Update Course Data</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-0">
                                    <h4 class="text-white text-center"> Add New Assignment </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/lecturer/courses/{{$crs->cid}}/addAssignment" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Course ID :</h6>
                                            <div class="col-md-12">
                                                <input id="cid" type="text" class="form-control" name="cid" value="{{$crs->cid}}" required autocomplete="cid" autofocus placeholder="Course ID">
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Assignment Title :</h6>
                                            <div class="col-md-12">
                                                <input id="assignmentTitle" type="text" class="form-control @error('assignmentTitle') is-invalid @enderror" name="assignmentTitle" value=" {{old('assignmentTitle')}} " required autocomplete="Assignment Title" autofocus placeholder="Assignment Title">
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Due Date : </h6>
                                            <div class="col-md-12">
                                                <input type="date" id="dueDate" name="dueDate" class="form-control" required min="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Assignment Weight : </h6>
                                            <div class="col-md-12">
                                                <input required min="0" max="100" id="aWeight" type="number" class="form-control" name="aWeight"  >
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Maximum Marks : </h6>
                                            <div class="col-md-12">
                                                <input required min="0" max="100" id="maxMarks" type="number" class="form-control" name="maxMarks"  >
                                            </div>
                                        </div>
                                            <div class="form-group content-center">
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="row col-md-12">
                                                        <button type="submit" class="btn btn-info btn-block text-white">Add Assignment </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-0">
                                    <h4 class="text-white text-center"> Add New Quiz </h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="/lecturer/courses/{{$crs->cid}}/addQuiz" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Course ID :</h6>
                                            <div class="col-md-12">
                                                <input id="cid" type="text" class="form-control" name="cid" value="{{$crs->cid}}" required autocomplete="cid" autofocus placeholder="Course ID">
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Quiz Title :</h6>
                                            <div class="col-md-12">
                                                <input id="quizTitle" type="text" class="form-control @error('quizTitle') is-invalid @enderror" name="quizTitle" value=" {{old('quizTitle')}} " required autocomplete="Quiz Title" autofocus placeholder="Quiz Title">
                                            </div>
                                        </div>
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Due Date : </h6>
                                            <div class="col-md-12">
                                                <input type="date" id="dueDate" name="dueDate" class="form-control" required min="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <!-- <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Assignment Weight : </h6>
                                            <div class="col-md-12">
                                                <input required min="0" max="100" id="aWeight" type="number" class="form-control" name="aWeight"  >
                                            </div>
                                        </div> -->
                                        <div class="form-group content-center">
                                            <h6 class="pl-3 text-muted"> Maximum Marks : </h6>
                                            <div class="col-md-12">
                                                <input required min="0" max="100" id="maxMarks" type="number" class="form-control" name="maxMarks"  >
                                            </div>
                                        </div>
                                            <div class="form-group content-center">
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="row col-md-12">
                                                        <button type="submit" class="btn btn-info btn-block text-white">Add Quiz </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header bg-info pb-0">
                                <h4 class="text-white text-center"> Course Information </h4>
                            </div>
                            <div class="card-body">
                                <p><strong> Course Code &emsp; &emsp; : </strong> {{$crs->cid}}</p>
                                <p><strong> Course Name &emsp; &emsp;: </strong> {{$crs->cName}}</p>
                                <p><strong> Year of Lecturing &ensp; : </strong> 2020</p>
                                <script type="application/javascript">
                                    (function(){
                                        'use strict';
                                        var $ = jQuery;
                                        $.fn.extend({
                                            filterTable: function(){
                                                return this.each(function(){
                                                    $(this).on('keyup', function(e){
                                                        $('.filterTable_no_results').remove();
                                                        var $this = $(this),
                                                            search = $this.val().toLowerCase(),
                                                            target = $this.attr('data-filters'),
                                                            $target = $(target),
                                                            $rows = $target.find('tbody tr');

                                                        if(search == '') {
                                                            $rows.show();
                                                        }else {
                                                            $rows.each(function(){
                                                                var $this = $(this);
                                                                $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                                                            })
                                                        }
                                                    });
                                                });
                                            }
                                        });
                                        $('[data-action="filter"]').filterTable();
                                    })(jQuery);
                                </script>
                                <div class="col-md-12 pb-2">
                                    <input type="text" class="form-control" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="Search for students..." />
                                </div>
                                <div class="table-responsive">
                                    <form method="POST" action="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses/enroll" enctype="multipart/form-data">
                                        @csrf
                                        <input hidden id="ccid" type="text" class="form-control" name="cid" value="{{$crs->cid}}"  >
                                        <table id=task-table class="table table-hover mb-0" style="border-collapse: collapse;">
                                            <thead class="text-center" style="background: #eee;">
                                                <tr style="display:block;">
                                                    <th scope="col">#</th>
                                                    <th scope="col">Index Number</th>
                                                    <th scope="col">Email</th>
                                                </tr>
                                            </thead>
                                            <tbody style="overflow-y:auto;display:block;height:400px">
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input onclick="getInput()" type="checkbox" class="custom-control-input" id="checkAll" value="true" >
                                                            <label class="custom-control-label" for="checkAll"></label>
                                                        </div>
                                                    </td>
                                                    <td colspan="2"> Enroll All</td>
                                                    <?php
                                                        $value="eue";
                                                        if($value=="true"){
                                                            $status = "checked";
                                                        } else{
                                                            $status = "";
                                                        }
                                                    ?>
                                                </tr>
                                                @foreach ($stu as $st)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="{{$st->index}}" name="enroll[]" id="{{$st->index}}" {{$status}} >
                                                            <label class="custom-control-label" for="{{$st->index}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{$st->index}}</td>
                                                    <td>{{$st->email}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="form-group d-flex justify-content-center">
                                            <button type="submit" class="btn btn-info btn-block text-white">Enroll</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
