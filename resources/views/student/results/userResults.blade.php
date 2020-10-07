@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
<script type="text/javascript">
    var list = <?php echo $graph; ?>;
</script>
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

            <div class="container-fluid" >
                <div class="row ">
                    <div class="col-md-12">
                        <div class ="pb-3">
                            <div class=" p-3 d-flex justify-content-between card bg-danger text-white shadow">
                                <div class="row mb-0 pb-0">
                                    <div class="col-1 mb-0 pb-0 d-flex justify-content-end">
                                        <h2 class=" mb-0 pb-0"> <i class="fa fa-exclamation-circle"></i> </h2>
                                    </div>
                                    <div class="col-11">
                                        <h6 class=" mb-0 pb-0"> Please note that these reports are generated upon the results that have been upladed and is not the final or approved GPA of the students and this may get changed at anytime. </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="background: rgba(52, 58, 64, 0.90)">
                            <div class="p-3 row rounded">
                                <div class="col-md-1 pb-2">
                                    <img class="rounded-circle border" style="max-width: 60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-11 pt-2 text-white">
                                    <div class="row d-flex justify-content-between align-items-baseline">
                                        <h5 class="pl-3"><strong>{{$user->name}}</strong></h5>
                                    </div>
                                    <div class="row pl-3">
                                        <h6  style="font-size:calc(0.6em + 0.2vw)"> Index : {{$user->index}} | Last-updated : {{$user->StuData->updated_at}}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <hr class=" mt-0 pt-0" style="width:98% ;background: white">
                            </div>
                            <div class="row px-4 pb-2 d-flex justify-content-center"  style="font-family:Helvetica;">
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow bg-transparent text-white rounded">
                                        <h1 class="text-center" style="font-size: calc(2em + 1.5vw);"><strong>{{$data["GPA"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white" style="font-size: calc(0.6em + 0.4vw);">Current GPA</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow text-white bg-transparent rounded" style="background: #fefefe">
                                        <h1 class="text-center" style="font-size: calc(2em + 1.5vw)"><strong>#{{$data["rank"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white" style="font-size: calc(0.6em + 0.4vw);">Current Rank</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow text-white bg-transparent rounded" style="background: #fefefe">
                                        <h1 class="text-center" style="font-size: calc(2em + 1.5vw)"><strong>{{$data["credits"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white" style="font-size: calc(0.6em + 0.4vw);">Total Credits</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                <div class="p-3 card border shadow text-white bg-transparent rounded">
                                        <h3 class="text-center" style="font-size: calc(2em + 1.5vw)"><strong>{{$data["sclass"]}}</strong></h3>
                                        <hr style="background: #fefefe">
                                <p class="text-center text-white" style="font-size: calc(0.6em + 0.4vw);">{{$data["class"]}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-4 d-flex justify-content-center">
                    <div class="col-md-6" style="font-family:Helvetica;">
                        <?php
                            for($i=3;$i>0;$i--){
                                for($j=2;$j>0;$j--){
                                    $gp = "gp". (string)$i .(string)$j ;
                                    $rank = "rank". (string)$i .(string)$j ;
                                    $totCredits = "totCredits".(string)$i .(string)$j ;
                                    $results = "results".(string)$i .(string)$j ;
                                    if($i==1){$pi = "1st" ;}
                                    else if($i==2){$pi = "2nd" ;}
                                    else if($i==3){$pi = "3rd" ;}
                                    else {$pi = "4th" ;}
                                    if($j==1){$pj = "1st" ;}
                                    else if($j==2){$pj = "2nd" ;}
                                    ?>
                                    @if ($data[$results]!==null)
                                        <div class="pb-3">
                                            <div class="card shadow">
                                                <div class="card-header bg-primary">
                                                    <h4 class="text-white pb-0 mb-0" style="font-size:calc(1.2em + 0.4vw)"> {{$pi}} Year {{$pj}} Semester</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.2em + 0.8vw);">{{$data[$gp]}} </h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> Semester GPA </h6>
                                                        </div>
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.2em + 0.8vw);">{{$data[$rank]}}</h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> Semester Rank </h6>
                                                        </div>
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.2em + 0.8vw);"> {{$user->stuData->$totCredits}} </h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> TotalCredits </h6>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @foreach ($data[$results] as $rs)
                                                        <div class="row ">
                                                            <div class="col-9">
                                                                <a href="/courses/{{$rs->course->cid}}" style="text-decoration:none;color:black">
                                                                    <h5 style="font-size:calc(0.8em + 0.3vw)">{{$rs->course->cName}}</h5>
                                                                </a>
                                                                <p class="text-muted" style="font-size:calc(0.6em + 0.2vw)">{{$rs->subjectCode}} / {{$rs->course->credits}} credits / year of examination : {{$rs->yoe}}</p>
                                                            </div>
                                                            <div class="col-3 d-flex justify-content-center">
                                                                <h2 class="font-weight-bold text-dark" style="font-size:calc(1.2em + 0.4vw);">{{$rs->grade}}</h2>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top: -5px">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="text-white pb-0 mb-0"> Grades Distribution </h4>
                                </div>
                                <div class="card-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="canvas" height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="text-white pb-0 mb-0"> Batch Ranking </h4>
                                </div>
                                <div class="card-body">
                                    <?php $i = 1?>
                                    @foreach ($gpaData as $bt)
                                        <a href="/results/{{$bt["id"]}}/{{$bt["name"]}}" style="text-decoration: none;">
                                            <div class="row d-flex justify-content-between" style="margin-bottom: -20px;color:black">
                                                <div class="col-2 pb-0 mb-0">
                                                <p style="font-size:calc(0.6em + 0.3vw)"> <strong>{{$i}}</strong></p>
                                                </div>
                                                <div class="col-6 pb-0 mb-0">
                                                    <p style="font-size:calc(0.6em + 0.3vw)"> <strong>{{$bt["index"]}} </strong></p>
                                                </div>
                                                <div class="col-4 pr-5 d-flex justify-content-end">
                                                    <p style="font-size:calc(0.6em + 0.3vw)"> <strong>{{$bt["GPA"]}} </strong> </p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php $i++ ?>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" style="width: 100%;height:auto" id="resultsview" tabindex="-1" role="dialog" aria-labelledby="resultsviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultsviewTitle">Post Something</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="pie_chart">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var grade = new Array();
    var countx = new Array();
    for (var key in list) {
        grade.push(key);
        countx.push(list[key]);
    }
    var ctx = document.getElementById("canvas");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels:grade,
            datasets: [{
                label: 'Grade',
                data: countx,
                borderWidth: 1,
                // backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
            }]
        },
    });
</script>

