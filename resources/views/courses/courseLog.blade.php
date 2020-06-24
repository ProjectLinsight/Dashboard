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
<div class="container-fluid pt-4">
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
                    <a href="/mycourses/{{Auth::user()->id}}/{{Auth::user()->name}}"><i class="fas fa-user pr-2"></i>My Courses</a>
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
                    <div class="col-md-5">
                        <div class="card shadow">
                            <div class="card-header bg-info pb-0">
                                <h4 class="text-white text-center">Results Overview</h4>
                            </div>
                            <div class="card-body">
                                <div id="pie_chart" style="width:auto; height:450px;">
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow">
                            <div class="card-header bg-info pb-0">
                                <h4 class="text-white text-center"> {{$log->cName}}</h4>
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
                                                <td class="border"><strong>40%</strong></td>
                                                <td class="border"> Summative Assessment </td>
                                                <td class="border"><strong>60%</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Pre-requisities </td>
                                                <td class="border" colspan="3"><strong>None</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="border"> Introduction </td>
                                                <td class="border text-justify" colspan="3"><strong>
                                                    In this course, you will learn the principles and methods which can be used to
                                                    develop effective user interfaces. The course will provide a balance of both
                                                    practical and theoretical knowledge. Practical concerns will be balanced by
                                                    discussion of relevant theory from the literature. You will solve problems in
                                                    take-home and in-class assessments where you will participate in group projects
                                                    to design, implement, and evaluate user interfaces. Through this course, you
                                                    will obtain necessary practical skills for designing user interfaces, an
                                                    understanding of the human side of computing, the background to apply
                                                    theoretical and empirical techniques in HCI, and a good overview of the field
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