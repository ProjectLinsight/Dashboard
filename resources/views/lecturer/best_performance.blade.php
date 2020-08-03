@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

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
                                <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/best_performance">Best Performances</a></h6>
                        </div>
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student_enrollment"><i class="fas fa-id-card pr-2"></i>Student Data</a>
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

            <div class="col-md-12">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Top Performances </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <div class="tab-content">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Registration Number</th>
                                                                <!-- <th>Name</th>   -->
                                                                <th>Name</th> 
                                                                <th>Degree</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           

                                                        </tbody>
                                                    </table>
                                                    <script>
                                                    document.addEventListener("DOMContentLoaded", ()=>{
                                                        const rows = document.querySelectorAll("tr[data-href]");
                                                        rows.forEach(row => {
                                                            row.addEventListener("click", () =>{
                                                                window.location.href = row.dataset.href;
                                                            });
                                                        });
                                                    });
                                                    </script>
                                                </div>
                                        </div>
                                        <div class="panel-body">
                                            <canvas id="canvas" height="180" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
</div>
                