@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>


@section('content')
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(255,255, 255, 0.75);width:100vw;height:100vh">
    </div>
</div>
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
            
                <hr><h1 class="text-center text-dark">Analytics</h1><hr>
                <!-- <div class="row"> -->
                <div class="col-md-12 pb-4">
                <div class="pb-3">
                    <div class="card shadow-sm">
                        <div class="card-body row">
                            <div class="col-md-6 px-4 row">
                                <!-- <div class="col-3">
                                    <img class="rounded-circle" style="max-width: 100%;height:auto"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div> -->
                                <div class="col-9">
                                    <div class="">
                                        <h4 style="font-size:calc(1.3em + 0.4vw)"> <strong>{{$crs->cName}}</strong> </h4>
                                        <h6 class="text-muted" style="font-size:calc(0.8em + 0.2vw)"> {{$crs->cid}}</h6>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6 row d-flex justify-content-end pt-3">
                                <div class="border-right border-left  px-4">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{$enrolled}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Enrolled students </strong></h6>
                                    </div>
                                </div>
                                <!-- <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                    @foreach (Auth::user()->lecAssigning as $item)
                                        <a href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">{{$item->cid}}</a> <br>
                                    @endforeach
                                        <h1></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Courses </strong></h6>
                                    </div>
                                </div> -->
                                <!-- <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{Auth::user()->posts->count()}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Interactions </strong></h6>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-4">
                    <hr>
                    <h3 class="text-center text-dark">Completions</h3>
                    <hr>
                    <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="my-0 text-white text-center"> Lecture Note Completion </h4>
                                </div>
                                <div class="card-body py-5">
                                    <div class="progress" style="height:4px">
                                        <?php
                                            $count = count($notes) ;
                                            $temp = 0 ;
                                            foreach($notes as $key => $val){
                                                $temp = $temp + 100/($count + 1);
                                                $padding = strval($temp)."%" ;
                                                if($val['count']!=$val['enrolled']){
                                                    $color = "danger";
                                                }
                                                else{
                                                    $color = "success";
                                                }
                                                ?>
                                                    <div class="py-3">
                                                        <div class="milestone4" style="left:{{$padding}};cursor: pointer;" >
                                                            <h5 class="text-{{$color}}" data-toggle="modal" data-target="#assignmentModel">
                                                                <i class="fa fa-address-book-o" aria-hidden="true"  data-toggle="tooltip" data-placement="top"  title="Assignment/s"></i>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="py-3">
                                                        <div class="milestone3 d-flex justify-content-center" style="left:{{$padding}};cursor: pointer;" data-toggle="tooltip" data-placement="top"  title="{{$key}}" >
                                                           <p class="text-primary" style="margin-top:10px;margin-left:-5px"> <strong> {{$key}} </strong> </p>
                                                           <p class="text-muted" style="margin-top:22px;margin-left:-50px" > <small>Viewed {{$val['count']}} of {{$val['enrolled']}} </small> </p>
                                                        </div>
                                                    </div>
                                                <div class="milestone bg-{{$color}}" style="left:{{$padding}};cursor: pointer;" data-toggle="tooltip" data-placement="top"  title="{{$key}}" > </div>
                                        <?php } ?>
                                        <!-- <div class="progress-bar bg-primary" style="width: 30%;"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                <div class="row">
                    <div class="col-md-6 py-3">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-primary pb-1">
                                    <h4 class="text-white text-center"> Assignment Completion </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">

                                    <!-- chart comes here -->

                                        <div class="panel-body">
                                            <canvas id="assignmentGraph" height="380" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 py-3">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-primary pb-1">
                                    <h4 class="text-white text-center"> Quiz Completion </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">

                                    <!-- chart comes here -->

                                        <div class="panel-body">
                                            <canvas id="quizGraph" height="380" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                    <h3 class="text-center text-dark">Assignments & Quizzes Analysis</h3>
                <hr>
                <div class="row">
                    <div class="col-md-7 py-3">
                    <!-- <div class="col-md-7"> -->
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Assignment Average </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="statGraph" height="300" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="col-md-7"> -->
                        
                    <!-- </div> -->
                    </div>
                    <div class="col-md-5 py-3">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-success pb-1">
                                    <h4 class="text-white text-center"> Assignments & Quizzes </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <nav class="nav nav-tabs nav-fill">
                                            <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#assignment">Assignments</a>
                                            <a class="col-6 nav-item nav-link" data-toggle="tab" href="#quiz">Quizzes</a>
                                        </nav>
                                        <div class="tab-content">
                                            <div id="assignment" class="tab-pane fade show active">
                                        
                                            <!-- assignment list comes here -->
                                            @foreach($stats as $key => $value)
                                            <!-- <div class="p-3">
                                                <div class="card shadow">
                                                    <div class="card-header text-white bg-info  d-flex justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                        <div class="row pt-1">
                                                            <h6 class="pt-1">
                                                                &ensp; {{$key}}
                                                            </h6>
                                                        </div>
                                                        <h4 class="pt-1"><i class="fa fa-angle-down" aria-hidden="true"></i></h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="collapse" id="collapseExample">
                                                            <div class="card card-body">
                                                                <hr>
                                                                @if($value['count'] != 0)
                                                                    <h6> <strong> Maximum &ensp; : &ensp; </strong> {{$value['max']}} </h6>
                                                                    <h6> <strong> Minimum &emsp;  : &ensp; </strong> {{$value['min']}} </h6>
                                                                    <h6> <strong> Average &emsp;  : &ensp; </strong> {{$value['avg']}} </h6>
                                                                    <br>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        {{$key}}
                                                        </button>
                                                    </h5>
                                                    </div>

                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                    @if($value['count'] != 0)
                                                                    <h6> <strong> Maximum &ensp; : &ensp; </strong> {{$value['max']}} </h6>
                                                                    <h6> <strong> Minimum &emsp;  : &ensp; </strong> {{$value['min']}} </h6>
                                                                    <h6> <strong> Average &emsp;  : &ensp; </strong> {{round($value['avg'], 2)}} </h6>
                                                                    
                                                    @endif
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                </div>
                                            @endforeach

                                            </div>
                                            <div id="quiz" class="tab-pane fade show">

                                            <!-- quizzes list comes here -->
                                            @foreach($quizstats as $key => $value)
                                            <div class="accordion" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne">
                                                    <h5 class="mb-0">
                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        {{$key}}
                                                        </button>
                                                    </h5>
                                                    </div>

                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                    @if($value['count'] != 0)
                                                                    <h6> <strong> Maximum &ensp; : &ensp; </strong> {{round($value['max'], 2)}} </h6>
                                                                    <h6> <strong> Minimum &emsp;  : &ensp; </strong> {{round($value['min'], 2)}} </h6>
                                                                    <h6> <strong> Average &emsp;  : &ensp; </strong> {{round($value['avg'], 2)}} </h6>
                                                                    
                                                    @endif
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                </div>
                                            @endforeach

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
                <hr>
                    <h3 class="text-center text-dark">Student Performence Analysis</h3>
                <hr>
                <!-- new row -->
                <div class="row">
                    <div class="col-md-7">
                    <!-- <div class="col-md-7"> -->
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Risk of failure </h4>
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
                                                                <th>Risk Level</th> 
                                                                <th>Risk Level</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($risks as $key => $value)
                                                            <tr data-href="/lecturer/{{Auth::user()->id}}/{{$course}}/{{$key}}/studentrisk">
                                                                @if ($value['risklevel']=='High' || $value['risklevel']=='Low')
                                                                    <td>{{$key}}</td>
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
                                                                    <td>
                                                                    <div class="progress">
                                                                        <div class="progress-bar progress-bar-striped {{$color}} progress-bar-animated" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%"></div>
                                                                    </div>
                                                                    </td>

                                                                @endif
                                                            </tr>
                                                            @endforeach

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
                    <div class="col-md-5">
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
                                                                <!-- <th>Degree</th>  -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($best as $key => $value)
                                                            <tr data-href="/lecturer/{{Auth::user()->id}}/{{$course}}/{{$key}}/studentrisk">
                                                                    <td>{{$key}}</td>
                                                                    <td>{{$value['name']}}</td>
                                                                
                                                            </tr>
                                                            @endforeach

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
                                            <canvas id="canvas" height="225" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                    
                    
                
                   
                </div>

        </div>
        <hr>
             <h3 class="text-center text-dark">Forum Analysis</h3>
         <hr>
        <div class="col-md-14">
                        <div class="pb-3">
                        <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Forum reminders </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <div class="tab-content">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Forum Topic</th>
                                                                <th>Thread</th> 
                                                                <th>Created by</th> 
                                                                <th>No of replies</th> 
                                                                <th>Responsed</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($forum as $key => $value)
                                                            <tr >
                                                                    <td>{{$value['forumTopic']}}</td>
                                                                    <td>{{$value['thread']}}</td>
                                                                    <td>{{$value['user']}}</td>
                                                                    <td>{{$value['replyCount']}}</td>
                                                                    @if ($value['response']=='No')
                                                                        <?php
                                                                            $color = "warning";
                                                                            $icon = "exclamation-circle";
                                                                        ?>
                                                                        @endif
                                                                    @if ($value['response']=='Yes')
                                                                        <?php
                                                                            $color = "success";
                                                                            $icon = "check-circle";
                                                                        ?>
                                                                        @endif
                                                                    <td><h3 class="pt-6 text-{{$color}}"> <i class="fa fa-{{$icon}}" aria-hidden="true"></i> </h3></td>
                                                            </tr>
                                                            @endforeach

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
                                            <canvas id="canvas" height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
    </div>
</div>



<script type="application/javascript">
        var assignment = <?php echo $assignment; ?>;
        var act = new Array();
        var countx = new Array();
        for (var key in assignment) {
            act.push(key);
            countx.push(assignment[key]);
        }
        console.log(countx);
        console.log(act);
        var ctx = document.getElementById("assignmentGraph");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:act,
                datasets: [{
                    label: 'Assignment Completion',
                    data: countx,
                    borderColor: '#2685CB',
                    hoverBackgroundColor: '#2685CB',
                    borderStyle: 'solid',
                    borderWidth: 2,
                    fill : false
                    
                }]
            },
            options:{
                scales: {
                     yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize : 1
                            },
                        scaleLabel: {
                            display: true,
                            labelString: 'No of Students'
                            }
                        }]
                    }
            }
        });
        var quiz = <?php echo $quiz; ?>;
        var qarr = new Array();
        var countq = new Array();
        for (var k in quiz) {
            qarr.push(k);
            countq.push(quiz[k]);
        }
        console.log(countq);
        console.log(qarr);
        var quizgraph = document.getElementById("quizGraph");
        var myChart = new Chart(quizgraph, {
            type: 'line',
            data: {
                labels:qarr,
                datasets: [{
                    label: 'Quiz Completion',
                    data: countq,
                    borderColor: '#2685CB',
                    hoverBackgroundColor: '#2685CB',
                    borderStyle: 'solid',
                    borderWidth: 2,
                    fill : false
                }]
            },
            options:{
                scales: {
                     yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize : 1
                            },
                        scaleLabel: {
                            display: true,
                            labelString: 'No of Students'
                            }
                        }]
                    }
            }
        });
        var stat = <?php echo $AsAvg; ?>;
        var sarr = new Array();
        var counts = new Array();
        for (var x in stat) {
            sarr.push(x);
            counts.push(stat[x]);
        }
        console.log(counts);
        console.log(sarr);
        var statgraph = document.getElementById("statGraph");
        var myChart = new Chart(statgraph, {
            type: 'line',
            data: {
                labels:sarr,
                datasets: [{
                    label: 'Assignment average',
                    data: counts,
                    borderColor: '#2685CB',
                    hoverBackgroundColor: '#2685CB',
                    borderStyle: 'solid',
                    borderWidth: 2,
                    fill : false
                }]
            },
            options:{
                scales: {
                     yAxes: [{
                        ticks: {
                            beginAtZero: true
                            },
                        scaleLabel: {
                            display: true,
                            labelString: 'Average Mark'
                            }
                        }]
                    }
            }
        });

</script>





