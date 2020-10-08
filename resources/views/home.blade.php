@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>

<script type="text/javascript">

    function getId(stmt) {
        console.log("statement" + stmt);
        document.getElementById("title").value=stmt;
    }
    function getDoc(des) {
        document.getElementById("link").value=des;
    }

    window.onload = function () {
        var date_counts = <?php echo $activityCount; ?>;
        var date_act = new Array();
        var date_countx = new Array();
        for (var key in date_counts) {
            date_act.push(key);
            date_countx.push(date_counts[key]);
        }
        var dategraph = document.getElementById("activityGraphPie");
        var myChart = new Chart(dategraph, {
            type: 'doughnut',
            data:{
                labels:date_act,
                datasets: [{
                    label: 'Activity Distribution',
                    data: date_countx,
                    borderWidth: 1,
                    backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
                }],
            },
            options:{
                responsive: true,
                title:{
                    display: true,
                    text: "Activity Distribution"
                }
            }
        });
        var outside = <?php echo $outsideData; ?> ;
        var out_act = new Array();
        var out_countx = new Array();
        for (var key in outside) {
            out_act.push(key);
            out_countx.push(outside[key]);
        }
        var outgraph = document.getElementById("outsideGraph");
        var myChart = new Chart(outgraph, {
            type: 'line',
            data:{
                labels:out_act,
                datasets: [{
                    label:'Outside Data Distribution',
                    data: out_countx,
                    borderWidth: 2,
                    backgroundColor: ["#0074D9"],
                    fill : false
                }],
            },
            options:{
                responsive: true,
                title:{
                    display: true,
                    text: "Outside Data Distribution"
                },
                scales:{
                    xAxes :[
                        {
                            scaleLabel:{
                                display : true ,
                                labelString : "Week Number"
                            },
                        },
                    ],
                    yAxes :[
                        {
                            ticks :{
                                beginAtZero : true,
                            },
                            scaleLabel:{
                                display : true ,
                                labelString : "Count"
                            },
                        }
                    ]
                }
            }
        });



        var actOverall = <?php echo $activityOverall; ?>;
        var colors = [ '#2685CB', '#4AD95A', '#FEC81B', '#FD8D14', '#CE00E6', '#4B4AD3', '#FC3026', '#B8CCE3', '#6ADC88', '#FEE45F'  ];
        var courseName = new Array();
        var courseCount = new Array();
        var datasetdata = new Array();
        var i = 0 ;
        for (var key in actOverall) {
            eval('var ' + key + '= new Array();');
            for (var key2 in actOverall[key]) {
                eval(key).push(actOverall[key][key2]);
            }
            datasetdata[i] = {
                label: key,
                data: eval(key),
                borderColor: colors[i],
                hoverBackgroundColor: colors[i],
                borderStyle: 'solid',
                borderWidth: 2,
                fill : false
            }
            i++;
        }

        var actgraph = document.getElementById("activityGraph");
        var myChart = new Chart(actgraph, {
            type: 'line',
            data:{
                labels:['w1', 'w2', 'w3', 'w4', 'w5','w6', 'w7', 'w8', 'w9', 'w10', 'w11', 'w12', 'w13', 'w14', 'w15'],
                datasets: datasetdata
            },
            options:{
                responsive: true,
                title:{
                    display: true,
                    text: "Activity Distribution"
                },

                scales:{
                    xAxes :[
                        {
                            scaleLabel:{
                                display : true ,
                                labelString : "Week Number"
                            },
                        },
                    ],
                    yAxes :[
                        {
                            ticks :{
                                beginAtZero : true,
                            },
                            scaleLabel:{
                                display : true ,
                                labelString : "Count"
                            },
                        }
                    ]
                }
            }

        });
    }
</script>

<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
</script>

@section('content')
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(255,255, 255, 0.75);width:100vw;height:100vh">
    </div>
</div>
<div class="container-fluid pt-4" style="font-size: 12px">
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
                <div class="p-3">
                    <button type="button" class="btn btn-outline-primary btn-block" data-toggle="modal" data-target="#exampleModalCenter">
                        <h6 class="pt-2"> <i class="far fa-edit pr-2"></i> write post <h6>
                    </button>
                </div>

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
                        <div class="card-body row">
                            <div class="col-md-5 px-4 row">
                                <div class="col-3">
                                    <img class="rounded-circle" style="max-width: 100%;height:auto"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div>
                                <div class="col-9">
                                    <div class="">
                                        <h4 style="font-size:calc(1.3em + 0.4vw)"> <strong>{{Auth::user()->name}}</strong> </h4>
                                        <h6 class="text-muted" style="font-size:calc(0.8em + 0.2vw)"> {{Auth::user()->email}}</h6>
                                        <hr class="m-0 p-0">
                                        <h6 class="mt-1" style="font-size:calc(0.8em + 0.2vw)"><strong> B.Sc. in {{Auth::user()->degree}} &ensp; | &ensp; {{Auth::user()->year}}</strong></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 row d-flex justify-content-end pt-3">
                                <div class="border-right border-left  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{Auth::user()->stu_enrollment->count()}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Enrolled Courses </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> 0 </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Completed Courses </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h1><strong> {{Auth::user()->posts->count()}} </strong></h1>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Interactions </strong></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-3">
                    <div class="card shadow-sm">
                        <div class="card-header pb-0 bg-primary text-white">
                            <h4> Overall Activity Distribution </h4>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-5">
                                <div class="card p-2" style="background: #fefefe">
                                    <canvas id="activityGraphPie" height="400" width="600"></canvas>
                                </div>
                            </div>
                            <div class="col-md-7 ">
                                <div class="card p-2" style="background: #fefefe">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <canvas id="activityGraph"  height="280" width="600"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid row m-0 changeList"  >
                <div class="col-md-7 py-3">
                    <div class="card shadow-sm" style="background: #fefefe">
                        <div class="card-header bg-primary">
                            <h4 class="text-white my-0"> Outside-VLE Data Management </h4>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <canvas id="outsideGraph"  height="280" width="600"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <script  type="application/javascript">

                            </script>

                            <div class="row">
                                <div class="col-8"><strong> Title </strong></div>
                                <div class="col-2"><strong> Date </strong></div>
                            </div>
                            @foreach($xapi as $stmt)
                                <hr>
                                <div class="row">
                                    <div class="col-8">
                                        <a href="{{$stmt['url']}}">  {{$stmt['title']}} </a>
                                    </div>
                                    <div class="col-2">
                                        <a href="{{$stmt['url']}}">  {{$stmt['date']}} </a>
                                    </div>
                                    <?php
                                        $obj1 = $stmt['title'];
                                        $obj2 = $stmt['url'];
                                    ?>
                                    <div class="col-2">
                                        <a type="button" class="btn btn-s" data-toggle="modal" data-target="#exampleModalCenter" onclick="getId('{{$obj1}}');  getDoc('{{$obj2}}');"   > <i class="fas fa-share-square pr-2"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-5 py-3">
                    <div class="pb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary">
                                <h4 class="text-white my-0"> Assignments and Quizzes</h4>
                            </div>
                            <div class="card-body">
                                <div class="panel panel-default">
                                    <nav class="nav nav-tabs nav-fill">
                                        <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#assignment">Assignments</a>
                                        <a class="col-6 nav-item nav-link" data-toggle="tab" href="#quiz">Quizzes</a>
                                    </nav>

                                    <div class="tab-content">
                                        <div id="assignment" class="tab-pane fade show active">
                                            @foreach($assignment as $subid => $value)
                                                @foreach($value as $keyassign)
                                                    <?php
                                                        if($keyassign->submitted == 'true'){
                                                            $icon = "check-circle";
                                                            $col = "success";
                                                        }
                                                        else{
                                                            $icon = "exclamation-circle";
                                                            $col = "danger";
                                                        }
                                                    ?>
                                                    <div class="p-0">
                                                        <div class="card">
                                                            <div class="row p-2">
                                                                <div class="col-1">
                                                                    <h1 class="pt-2 text-{{$col}}"> <i class="fa fa-{{$icon}}" aria-hidden="true"></i> </h1>
                                                                </div>
                                                                <div class="col-8 pl-4 pr-0 mx-0 pt-2">
                                                                    <h6><strong>{{$keyassign->title}} </strong> </h6>
                                                                    <h6 style="font-size: 0.9em" class="text-muted"><strong>{{$subid}}</strong></h6>
                                                                </div>
                                                                <div class="col-3 px-0 pt-2">
                                                                    <h6 style="font-size: 1.0em" class="text-muted">Due Date</h6>
                                                                    <h6 class="pt-2"><strong>{{$keyassign->dueDate}}</strong></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div id="quiz" class="tab-pane fade show">
                                        @foreach($quiz as $subid => $value)
                                            @foreach($value as $keyquiz)
                                                <?php
                                                    if($keyquiz->submitted == 'true'){
                                                        $icon = "check-circle";
                                                        $col = "success";
                                                    }
                                                    else{
                                                        $icon = "exclamation-circle";
                                                        $col = "danger";
                                                    }
                                                ?>
                                                <div class="p-0">
                                                    <div class="card">
                                                        <div class="row p-2">
                                                            <div class="col-1">
                                                                <h1 class="pt-2 text-{{$col}}"> <i class="fa fa-{{$icon}}" aria-hidden="true"></i> </h1>
                                                            </div>
                                                            <div class="col-8 pl-4 pr-0 mx-0 pt-2">
                                                                <h6><strong>{{$keyquiz->title}} </strong> </h6>
                                                                <h6 style="font-size: 0.9em" class="text-muted"><strong>{{$subid}}</strong></h6>
                                                            </div>
                                                            <div class="col-3 px-0 pt-2">
                                                                <h6 style="font-size: 1.0em" class="text-muted">Due Date</h6>
                                                                <h6 class="pt-2"><strong>{{$keyquiz->dueDate}}</strong></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
    </div>
</div>







{{-- Modal for write post --}}
<div class="modal fade" style="width: 100%;height:auto" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Post Something</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/post" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12 px-0">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12 px-0">
                            <label for="sel1">Select course:</label>
                                <select class="form-control" id="sel1" name="course_code" required autocomplete="course_code" autofocus placeholder="Course code">
                                    @foreach (Auth::user()->stu_enrollment as $sub)
                                         <option>&emsp; {{$sub->cid}}</option>
                                     @endforeach
                                 </select>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input  id="link" type="text" class="form-control mb-3" name="link" autocomplete="link" autofocus placeholder="Add Link">

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <textarea id="description" type="text" style="height: 110px;" class="form-control @error('description') is-invalid @enderror" name="description" >  </textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" autocomplete="image" autofocus>
                                <label class="custom-file-label" for="image" data-browse="Bestand kiezen">Upload image (optional) </label>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block text-white">Share Post</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

