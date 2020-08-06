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
                        </div>
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                <a data-toggle="collapse" href="#coursesdata"><i class="fas fa-id-card pr-2"></i>Student Data</a>
                    <div class="collapse pt-3 pl-5" id="coursesdata">
                        @foreach (Auth::user()->lecAssigning as $item)
                            <h6 class="text-white">
                                <a href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/students">{{$item->cid}}</a>
                            </h6>
                        @endforeach
                    </div>
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card table-card shadow">
                            <div class="card-header bg-info pb-1">
                                <h4 class="text-white text-center">Enrolled students</h4>
                            </div>
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Username</th>
                                                                <th>Name</th>
                                                                <th>Risk</th>
                                                                <th>Level</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($best as $key => $value)
                                                            <tr data-href="/lecturer/{{Auth::user()->id}}/{{$course}}/{{$key}}/studentrisk">
                                                               
                                                                    <td>{{$key}}</td>
                                                                    <td>{{$value['name']}}</td>
                                                                    <td>{{$value['risklevel']}}</td>
                                                                    @if ($value['risklevel']=='High')
                                                                        <?php
                                                                            $color = "bg-danger";
                                                                            $percentage = 100;
                                                                        ?>
                                                                        @endif
                                                                    @if ($value['risklevel']=='Low')
                                                                        <?php
                                                                            $color = "bg-warning";
                                                                            $percentage = 50;
                                                                        ?>
                                                                        @endif
                                                                    @if ($value['risklevel']=='No')
                                                                        <?php
                                                                            $color = "bg-success";
                                                                            $percentage = 0;
                                                                        ?>
                                                                        @endif
                                                                    <td>
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-striped {{$color}} progress-bar-animated" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%"></div>
                                                                    </div>
                                                                    </td>

                                                               
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
    </div>
</div>









