@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
    <script type="text/javascript">
        window.onload = function () {
            var activity = <?php echo $activity; ?>;
            var act = new Array();
            var countx = new Array();
            for (var key in activity) {
                act.push(key);
                countx.push(activity[key]);
            }
            var ctx = document.getElementById("activityGraph");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:act,
                    datasets: [{
                        label: 'Activity by type',
                        data: countx,
                        borderWidth: 1,
                        backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
                    }]
                },
            });

            var date_counts = <?php echo $date_counts; ?>;
            var date_act = new Array();
            var date_countx = new Array();
            for (var key in date_counts) {
                date_act.push(key);
                date_countx.push(date_counts[key]);
            }
            var dategraph = document.getElementById("dateGraph");
            var myChart = new Chart(dategraph, {
                type: 'line',
                data: {
                    labels:date_act,
                    datasets: [{
                        label: 'Activity over Time (Daily)',
                        data: date_countx,
                        borderWidth: 1,
                        borderColor : "#0074D9",
                        backgroundColor : ['rgba(0, 116, 217, 0.4)' ]
                    }]
                }
            });

            var week_counts = <?php echo $week_counts; ?>;
            var week_act = new Array();
            var week_countx = new Array();
            for (var key in week_counts) {
                week_act.push("W"+key);
                week_countx.push(week_counts[key]);
            }
            console.log(week_countx);
            var weekgraph = document.getElementById("weekGraph");
            var myChart = new Chart(weekgraph, {
                type: 'line',
                data: {
                    labels:week_act,
                    datasets: [{
                        label: 'Activity over Time (Weekly)',
                        data: week_countx,
                        borderWidth: 1,
                        borderColor : "#0074D9",
                        backgroundColor : ['rgba(0, 116, 217, 0.4)' ]
                    }]
                }
            });
        }
    </script>

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
           
                        @endforeach
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- new stuff -->

            <div class="container-fluid pt-5">
                <div class="pb-4">
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
                                                if($val['count']==0){
                                                    $color = "danger";
                                                }
                                                else{
                                                    $color = "success";
                                                }
                                                ?>
                                                    <div class="py-3">
                                                        <div class="milestone2" style="left:{{$padding}};cursor: pointer;" >
                                                            <h5 class="text-{{$color}}" data-toggle="modal" data-target="#assignmentModel">
                                                                <i class="fa fa-address-book-o" aria-hidden="true"  data-toggle="tooltip" data-placement="top"  title="Assignment/s"></i>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="py-3">
                                                        <div class="milestone3 d-flex justify-content-center" style="left:{{$padding}};cursor: pointer;" data-toggle="tooltip" data-placement="top"  title="{{$key}}" >
                                                           <p class="text-primary"> <strong> {{$key}} </strong> </p>
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
                    <div class="col-md-7">
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="text-white my-0"> Activity Distribution </h4>
                                </div>
                                <div class="card-body">
                                    <nav class="nav nav-tabs nav-fill">
                                        <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#dailyTab">Daily</a>
                                        <a class="col-6 nav-item nav-link" data-toggle="tab" href="#weeklyTab">Weekly</a>
                                    </nav>
                                    <div class="tab-content">
                                        <div id="dailyTab" class="tab-pane fade show active">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <canvas id="dateGraph" height="300px" width="600"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="weeklyTab" class="tab-pane fade show">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <canvas id="weekGraph" height="300px" width="600"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="text-white my-0 py-0"> Contribution to the Course </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="activityGraph" height="380px" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-7">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Outside VLE Actions </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <div class="tab-content">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>URL</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($links as $key => $value)
                                                            <tr >
                                                                    <td>{{$value['title']}}</td>
                                                                    <td>{{$value['url']}}</td>
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
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Forum Participation </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <div class="tab-content">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>URL</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($risks as $key => $value)
                                                            <tr >
                                                                @if ($value['risklevel']=='High' || $value['risklevel']=='Low')
                                                                    <td>{{$key}}</td>
                                                                    <td>{{$value['risklevel']}}</td>

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
                                            <canvas id="canvas" height="480" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
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
                                            <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Assignment</th>
                                                                <!-- <th>Name</th>   -->
                                                                <th>Mark</th>
                                                            </tr>
                                                        </thead>
                                            @foreach ($crs2->assignment as $assignment)
                                                
                                                    <?php
                                                        $flag = "You haven't submitted this assignment";
                                                        $color = "bg-danger";
                                                        $icon = "exclamation-circle"
                                                    ?>
                                                    @foreach ($submittedAssignments as $submitted)
                                                        @if($assignment->title==$submitted['title'])
                                                            <?php
                                                                $flag = "You have submitted this assignment and grades pending" ;
                                                                $color = "bg-primary";
                                                                $icon = "clock-o";
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($gradedAssignments as $graded)
                                                        @if($assignment->title==$graded['title'])
                                                            <?php
                                                                $flag = "Your assignment is Submitted and Graded";
                                                                $color = "bg-success";
                                                                $icon = "check-circle";
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    <!-- <div class="p-3">
                                                        <div class="card shadow">
                                                            <div class="card-header text-white {{$color}}  d-flex justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                                <div class="row pt-1">
                                                                    <h1 class="px-4 pt-1">
                                                                        <i class="fa fa-{{$icon}}" aria-hidden="true"></i>
                                                                    </h1>
                                                                    <h4 class="pt-1">
                                                                        {{$assignment->title}}
                                                                    </h4>
                                                                </div>
                                                                <h4 class="pt-1"><i class="fa fa-angle-down" aria-hidden="true"></i></h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="collapse" id="collapseExample">
                                                                    <div class="card card-body">
                                                                        <h4> <strong> {{$flag}} </strong></h4>
                                                                        <hr>
                                                                        @if($flag == "Your assignment is Submitted and Graded")
                                                                            <h6> <strong> Assignment Weight  &ensp; : &ensp; </strong> {{$assignment->weight}} out of 100  </h6>
                                                                            <h6> <strong> Marks Obtained  &emsp;  &emsp; : &ensp; </strong> {{$graded['marks']}} out of {{$assignment->maxMarks}} </h6>
                                                                            <br>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    
                                                        <tbody>
                                                            <tr >
                                                                    <td>
                                                                    <div class="row pt-1">
                                                                        <h6 class="px-4 pt-1">
                                                                            <i class="fa fa-{{$icon}}" aria-hidden="true"></i>
                                                                        </h6>
                                                                        <h6 class="pt-1">
                                                                            {{$assignment->title}}
                                                                        </h6>
                                                                    </div>
                                                                    </td>
                                                                    <td>
                                                                    @if($flag == "Your assignment is Submitted and Graded")
                                                                            <h6> <strong>{{$graded['marks']}} out of {{$assignment->maxMarks}} </h6>
                                                                        @endif
                                                                    @if($flag == "You haven't submitted this assignment")    
                                                                        <h6> Not Completed</h6>
                                                                    @endif
                                                                    @if($flag == "You have submitted this assignment and grades pending")    
                                                                        <h6> Pending mark</h6>
                                                                    @endif
                                                                    </td>
                                                            </tr>

                                                        </tbody>
                                                    
                                                
                                            @endforeach
                                            </table>
                                            </div>
                                            <div id="quiz" class="tab-pane fade show">

                                            <!-- quizzes list comes here -->
                                            <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Quiz</th>
                                                                <!-- <th>Name</th>   -->
                                                                <th>Mark</th>
                                                            </tr>
                                                        </thead>
                                            @foreach ($crs2->quiz as $quiz)
                                                
                                                    <?php
                                                        $flag = "You haven't submitted this assignment";
                                                        $color = "bg-danger";
                                                        $icon = "exclamation-circle"
                                                    ?>
                                                    @foreach ($quizzes as $completed)
                                                        @if($quiz->title==$completed['title'])
                                                            <?php
                                                                $flag = "Your assignment is Submitted and Graded";
                                                                $color = "bg-success";
                                                                $icon = "check-circle";
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                        <tbody>
                                                            <tr >
                                                                    <td>
                                                                    <div class="row pt-1">
                                                                        <h6 class="px-4 pt-1">
                                                                            <i class="fa fa-{{$icon}}" aria-hidden="true"></i>
                                                                        </h6>
                                                                        <h6 class="pt-1">
                                                                            {{$quiz->title}}
                                                                        </h6>
                                                                    </div>
                                                                    </td>
                                                                    <td>
                                                                    @if($flag == "Your assignment is Submitted and Graded")
                                                                            <h6> <strong>{{$completed['marks']}} out of {{$quiz->maxMarks}} </h6>
                                                                        @endif
                                                                    @if($flag == "You haven't submitted this assignment")    
                                                                        <h6> Not Completed</h6>
                                                                    @endif
                                                                    </td>
                                                            </tr>

                                                        </tbody>
                                                    
                                                
                                            @endforeach
                                            </table>
                                            

                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <canvas id="canvas" height="480" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                