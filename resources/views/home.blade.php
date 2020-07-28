@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>

<script type="text/javascript">
    window.onload = function () {
        // ctx = document.getElementById('myChart').getContext('2d');
        // chart = new Chart(ctx, {
        //     type: 'pie',
        //     data: {
        //         datasets: [{
        //             label: 'Colors',
        //             data: [9, 8, 7, 6, 5, 4, 3, 2, 1],
        //             backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
        //         }],
        //         labels: ['a','b','c','d','e','f','g','h','i']
        //     },
        //     options: {
        //         responsive: true,
        //         title:{
        //             display: true,
        //             text: "Color test"
        //         }
        //     }
        // });

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
            data: {
                labels:date_act,
                datasets: [{
                    label: 'Activity Distribution',
                    data: date_countx,
                    borderWidth: 1,
                    backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"]
                }],
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: "Activity Distribution"
                    }
            }
        });



        var canvas = document.getElementById('activityGraph');
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['w1', 'w2', 'w3', 'w4', 'w5','w6', 'w7', 'w8', 'w9', 'w10', 'w11', 'w12', 'w13', 'w14', 'w15'],
                datasets: [{
                    label: 'Subject 1',
                    data: [10, 19, 14, 26, 9 ,12 , 45 , 23, 2 , 10, 34, 13, 20,8,14],
                    borderWidth: 1,
                    fill: false,
                    borderColor: ["#0074D9"]

                },{
                    label: 'Subject 2',
                    data: [11, 16, 31, 14, 12, 13, 20, 8, 14, 23, 34, 40,12, 20,9],
                    borderWidth: 1,
                    fill: false,
                    borderColor: ["#FF4136"]
                }]
            },
        });
    }
</script>
@section('content')
<div class="container-fluid pt-4" style="font-size: 12px">
    <div id="wrapper" class="wrapper-content" >
        <div id="sidebar-wrapper" class="bg-dark">
            <ul class="sidebar-nav">
                <li class="sidebar-brand pl-0">
                    <h6 class="h6-sized pl-3">{{Auth::user()->email}}<h6>
                </li>
                <li class="pt-3">
                    <a href="/home"><i class="fas fa-home pr-2"></i>Feed</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a data-toggle="collapse" href="#courses"> <i class="fas fa-user pr-2"></i> Courses </a>
                    <div class="collapse pt-1 pl-5" id="courses">
                        @foreach (Auth::user()->stu_enrollment as $sub)
                            <h6 class="h6-sized text-white"><a href="/Mycourses/{{$sub->cid}}" >{{$sub->cid}}</a></h6>
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
                <li>
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
                                        <h3><strong> {{Auth::user()->stu_enrollment->count()}} </strong></h3>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Enrolled Courses </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h3><strong> 0 </strong></h3>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> Completed Courses </strong></h6>
                                    </div>
                                </div>
                                <div class="border-right  px-5">
                                    <div class="d-flex justify-content-end">
                                        <h3><strong> {{Auth::user()->posts->count()}} </strong></h3>
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
                    <hr>
                    <h1 class="text-center text-dark"> <strong>Timeline </strong> </h1>
                    <hr>
                    <?php $post = App\Post::all() ?>
                    @foreach ($post as $post)
                    <div class="pb-4">
                        <div class="p-3 rounded shadow" style="background:white;">
                            <div class="row d-flex justify-content-between">
                                <div class=" col-10 d-flex">
                                    <div class="p-2">
                                        <img class="rounded-circle" style="max-width: 60px;height:60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                    </div>
                                    <div class="col-8">
                                        <div class="row d-flex justify-content-between align-items-baseline">
                                            <div>
                                                <h5 class="pt-3" style="font-size:calc(1em + 0.4vw)"><strong>{{$post->user->name}}</strong></h5>
                                                @if ($post->created_at!==$post->updated_at)
                                                    <h6 class="text-muted " style="font-size:calc(0.6em + 0.1vw)" data-toggle="tooltip" title="post created : {{$post->created_at}}">  {{$post->updated_at}}</h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="p-3 border rounded" style="background: #fefefe">
                                <h5 style="font-size:calc(1.2em + 0.2vw)"><strong>{{ $post->title}}</strong></h5>
                                <hr>
                                <p style="font-size:calc(0.9em + 0.1vw);text-align: justify">{{$post->description}}</p>
                                @if ($post->image)
                                    <div class="d-flex justify-content-center">
                                        <img style="width:100%;height:auto;" src="uploads/post/{{ $post->image }}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-5 py-3">
                    <div class="pb-3">
                        <div class="card shadow">
                            <div class="card-header bg-info">
                                <h5 class="text-white my-0"> Overall Activity Distribution </h5>
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
                            <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <textarea id="description" type="text" style="height: 110px;" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Description"></textarea>
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
                                <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>
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

