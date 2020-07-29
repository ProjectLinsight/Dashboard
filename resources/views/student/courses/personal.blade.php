@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
    <script type="text/javascript">
        var analytics = <?php echo $grade; ?>

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(){
            var data = google.visualization.arrayToDataTable(analytics);
            var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
            chart.draw(data);
        }
    </script>

@section('content')
<div class="container-fluid pt-5" style="font-size: 12px">
    <div id="wrapper" class="wrapper-content" >
        <div id="sidebar-wrapper" class="bg-dark">
            <ul class="sidebar-nav">
                <li class="sidebar-brand pl-0">
                    <h6>{{Auth::user()->email}}<h6>
                </li>
                <li class="pt-3">
                    <a href="/home"><i class="fas fa-home pr-2"></i>Feed</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a data-toggle="collapse" href="#courses"> <i class="fas fa-book pr-2"></i> Courses </a>
                    <div class="collapse pt-1 pl-5" id="courses">
                        @foreach (Auth::user()->stu_enrollment as $sub)
                            <a style="font-size: 12px" href="/Mycourses/{{$sub->cid}}" > &emsp; {{$sub->cid}}</a>
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/results/{{Auth::user()->id}}/{{Auth::user()->name}}"><i class="fas fa-chart-line pr-2"></i>Results</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                <a href="/profile/{{Auth::user()->id}}/{{Auth::user()->name}}"><i class="fas fa-user pr-2"></i>Profile</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/courses"><i class="fas fa-id-card pr-2"></i>Course Data</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student/analysis"><i class="fas fa-chart-bar pr-2"></i>Analysis</a>
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
                    <div class="col-md-8">
                        <hr><h1 class="text-center"> {{$crs->cName}} </h1><hr>
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-info">
                                    <h4 class="text-white my-0"> Activity Distribution </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="dateGraph" height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="my-0 text-white"> Your Progress </h4>
                                </div>
                                <div class="card-body py-5">
                                    <div class="progress" style="height:10px">
                                        <?php
                                            $count = 4 ;
                                            $temp = 0 ;
                                            for($i=0;$i<$count;$i++){
                                                $temp = $temp + 100/($count + 1)  ;
                                                $padding = strval($temp)."%" ; ?>
                                            <div class="milestone bg-primary" style="left:{{$padding}}"></div>
                                        <?php } ?>
                                        <div class="progress-bar bg-primary" style="width: 30%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($crs->assignment as $assignment)
                            <div class="pb-3">
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
                                <div class="card shadow">
                                    <div class="card-header text-white {{$color}}  d-flex justify-content-between" style="cursor: pointer;" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        <div class="row pt-1">
                                            <h1 class="px-4 pt-1">
                                                <i class="fa fa-{{$icon}}" aria-hidden="true"></i>
                                            </h1>
                                            <h4 class="pt-2">
                                                {{$assignment->title}}
                                            </h4>
                                        </div>
                                        <h4 class="pt-2"><i class="fa fa-angle-down" aria-hidden="true"></i></h4>
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
                            </div>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-info">
                                    <h4 class="text-white my-0"> Contribution status </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="activityGraph" height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header bg-info text-center text-white">
                                <h4 class="my-0"> Results Overview</h4>
                            </div>
                            <div class="card-body">
                                <div id="pie_chart">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
        var activity = <?php echo $activity; ?>;
        var act = new Array();
        var countx = new Array();
        for (var key in activity) {
            act.push(key);
            countx.push(activity[key]);
        }
        console.log(countx);
        var ctx = document.getElementById("activityGraph");
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels:act,
                datasets: [{
                    label: 'Activity by type',
                    data: countx,
                    borderWidth: 1,
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
                    label: 'Activity over Time',
                    data: date_countx,
                    borderWidth: 1,
                }]
            }
        });
</script>
