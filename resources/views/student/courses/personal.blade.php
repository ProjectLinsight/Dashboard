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
                    <a data-toggle="collapse" href="#courses" ><i class="fas fa-user pr-2"></i>Courses</a>
                    <div class="collapse pt-3 pl-5" id="courses">
                        @foreach (Auth::user()->stu_enrollment as $sub)
                            <h6 class="text-white"><a href="/Mycourses/{{$sub->cid}}" >{{$sub->cid}}</a></h6>
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
                        <hr><h1 class="text-center"> {{$crs[0]}} </h1><hr>
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info">
                                    <h4 class="text-white my-0"> Activity Distribution </h4>
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

                        <table>
                            @foreach($counts as $key => $value)
                                <tr>
                                    <td>{{$key}} &emsp; {{$value}}

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="col-md-4">
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
                    label: 'Activity',
                    data: countx,
                    borderWidth: 1,
                }]
            },
        });
</script>
