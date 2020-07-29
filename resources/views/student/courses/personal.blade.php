@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                <hr>
                <h1 class="text-center"> {{$crs->cName}} </h1>
                <hr>

                <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="my-0 text-white"> Your Progress </h4>
                                </div>
                                <div class="card-body py-5">
                                    <div class="progress" style="height:4px">
                                        <?php
                                            $count = 15 ;
                                            $temp = 0 ;
                                            for($i=1;$i<=$count;$i++){
                                                $temp = $temp + 100/($count + 1);
                                                $padding = strval($temp)."%" ;
                                                if($i< $duration && $weeklyAssignments[$i] ){  ?>
                                                    <div class="py-3">
                                                        <div class="milestone2" style="left:{{$padding}};cursor: pointer;" >
                                                            <h5 data-toggle="modal" data-target="#assignmentModel">
                                                                <i class="fa fa-address-book-o" aria-hidden="true"  data-toggle="tooltip" data-placement="top"  title="{{count($weeklyAssignments[$i])}} Assignment/s"></i></h5>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                    <div class="py-3">
                                                        <div class="milestone3 d-flex justify-content-center" style="left:{{$padding}};cursor: pointer;" data-toggle="tooltip" data-placement="top"  title="Week {{$i+1}} of 15 " >
                                                           <p class="text-primary"> <strong> W{{$i}} </strong> </p>
                                                        </div>
                                                    </div>
                                                <div class="milestone bg-primary" style="left:{{$padding}};cursor: pointer;" data-toggle="tooltip" data-placement="top"  title="Week {{$i+1}} of 15 " > </div>
                                        <?php } ?>
                                        <div class="progress-bar bg-primary" style="width: 30%;"></div>
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
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" id="assignmentModel" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="p-2">
                <div class="card bg-success pt-2 px-2 ">
                    <h6 class="text-white ">  <i class="fa fa-check-circle" aria-hidden="true"></i> Assignment Name </h6>
                </div>
            </div>
            <div class="p-2">
                <div class="card bg-success pt-2 px-2 ">
                    <h6 class="text-white ">  <i class="fa fa-check-circle" aria-hidden="true"></i> Assignment Name </h6>
                </div>
            </div>
        </div>
    </div>
</div>
