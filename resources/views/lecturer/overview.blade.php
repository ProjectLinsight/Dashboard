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
                            <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Overview</a></h6>
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
                <hr><h1 class="text-center text-dark">Analytics</h1><hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Assignment Completion </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">

                                    <!-- chart comes here -->

                                        <div class="panel-body">
                                            <canvas id="assignmentGraph" height="280" width="600"></canvas>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-info pb-1">
                                    <h4 class="text-white text-center"> Activity Completion </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">

                                    <!-- chart comes here -->

                                        <div class="panel-body">
                                            <canvas id="canvas" height="280" width="600"></canvas>
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
        
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-dark pb-1">
                                    <h4 class="text-white text-center"> Risk of failure </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="panel panel-default">
                                        <nav class="nav nav-tabs nav-fill">
                                            <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#CS">Computer Science</a>
                                            <a class="col-6 nav-item nav-link" data-toggle="tab" href="#IS">Information Systems</a>
                                        </nav>
                                        <div class="tab-content">
                                            <div id="CS" class="tab-pane fade show active">

                                            <!-- CS risk of failure list comes here -->

                                            </div>
                                            <div id="CS" class="tab-pane fade show active">

                                            <!-- IS risk of failure list comes here -->

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
                                <div class="card-header bg-info pb-1">
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

                                            </div>
                                            <div id="quiz" class="tab-pane fade show active">

                                            <!-- quizzes list comes here -->

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
            type: 'bar',
            data: {
                labels:act,
                datasets: [{
                    label: 'Assignment Completion',
                    data: countx,
                    borderWidth: 1,
                }]
            },
        });

        
</script>
