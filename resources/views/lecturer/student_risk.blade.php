@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>


@section('content')
<div class="container-fluid pt-5">
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
            <div class="container-fluid">
                <div class="pb-3">
                    <div class="card shadow-sm">
                    @foreach ($stuDetails as $key => $value)
                        <div class="card-body row">
                            <div class="col-md-5 px-4 row">
                                <div class="col-3">
                                    <img class="rounded-circle" style="max-width: 100%;height:auto"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div>
                                <div class="col-9">
                                    <div class="">
                                        <h4 style="font-size:calc(1.3em + 0.4vw)"> <strong>{{$value['name']}}</strong> </h4>
                                        <h6 class="text-muted" style="font-size:calc(0.8em + 0.2vw)"> {{$value['email']}}</h6>
                                        <hr class="m-0 p-0">
                                        <h6 class="mt-1" style="font-size:calc(0.8em + 0.2vw)"><strong> B.Sc. in {{$value['degree']}} &ensp; | &ensp; {{$value['year']}}</strong></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 row d-flex justify-content-end pt-3">
                                <div class="border-right border-left  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{$value['rlevel']}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Risk Level </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-3">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{$value['aavg']}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Average Assignment Marks </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-3">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{$value['qavg']}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Average Quiz Marks </strong></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="pb-3">
                    <div class="card shadow-sm">
                        <div class="card-header pb-0 bg-primary text-white">
                            <h4> Overall Activity Distribution </h4>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-5">
                                <div class="card p-2" style="background: #fefefe">
                                    <canvas id="activityGraphPie" height="400" width="600"></canvas>
                                </div>
                            </div>
                            <div class="col-md-7 ">
                                <div class="card p-2" style="background: #fefefe">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="activityGraph"  height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
