@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(255,255, 255, 0.75);width:100vw;height:100vh">
    </div>
</div>
<div class="container-fluid pt-4">
    <div id="wrapper" class="wrapper-content" >
        <div id="sidebar-wrapper" class="bg-dark">
            <ul class="sidebar-nav">
                <li class="sidebar-brand pl-0">
                    <h6 class="h6-sized pl-3">{{Auth::user()->email}}<h6>
                </li>
                <li class="pt-3">
                    <a href="/home"><i class="fas fa-chart-bar pr-2"></i>Overview</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student/analysis"><i class="fas fa-home pr-2"></i>Timeline</a>
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
                <h1 class="text-center">{{$log->cName}}</h1>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-header bg-info pb-0">
                                <h4 class="text-white text-center">Results Overview</h4>
                            </div>
                            <div class="card-body">
                                <div id="pie_chart" style="width:auto; height:430px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-header bg-info pb-0">
                                <h4 class="text-white text-center"> Course Information </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" style="border-collapse: collapse;">
                                        <tbody  style="font-size: calc(0.7em + 0.2vw)">
                                            <tr>
                                                <td class="border"> Course Code </td>
                                                <td class="border" colspan="3"><strong>{{$log->cid}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Course Name </td>
                                                <td class="border" colspan="3"><strong>{{$log->cName}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Year </td>
                                                <td class="border"><strong>{{substr(preg_replace("/[^0-9]/","",$log->cid),0,1)}}</strong></td>
                                                <td class="border"> Semester </td>
                                                <td class="border"><strong>{{$log->semester}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Course Credits </td>
                                                <td class="border" colspan="3"><strong>{{$log->credits}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Formative Assessment </td>
                                                <td class="border"><strong>{{$log->assignmentMarks}}</strong></td>
                                                <td class="border"> Summative Assessment </td>
                                                <td class="border"><strong>{{$log->examMarks}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Pre-requisities </td>
                                                <td class="border" colspan="3"><strong>{{$log->prerequisites}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Introduction </td>
                                                <td class="border text-justify" colspan="3"><strong>
                                                    {{$log->introduction}}
                                                </strong></td>
                                            </tr>
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
@endsection
