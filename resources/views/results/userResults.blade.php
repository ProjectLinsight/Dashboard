@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
                    <a href="/home"><i class="fas fa-home pr-2"></i>Feed</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="#"><i class="fas fa-book pr-2"></i>My Courses</a>
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

            <div class="container-fluid" >
                <div class="row ">
                    <div class="col-md-12">
                        <div class="card bg-dark" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                            <div class="p-3 row rounded"> 
                                <div class="col-md-1 pb-2">
                                    <img class="rounded-circle border" style="max-width: 60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-11 text-white">
                                    <div class="row d-flex justify-content-between align-items-baseline">
                                        <h5 class="pl-3"><strong>{{$user->name}}</strong></h5>
                                    </div>
                                    <div class="row pl-3">
                                        <h6  style="font-size:calc(0.6em + 0.2vw)"> Index : {{$user->index}} | Last-updated : {{$user->StuData->updated_at}}</h6>
                                    </div>
                                </div>  
                            </div>
                            <div class="d-flex justify-content-center">
                                <hr style="width:98% ;background: white">  
                            </div>
                            <div class="row px-4 pb-2 d-flex justify-content-center"  style="font-family:Helvetica;">
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                        <h1 class="text-center" style="font-size: 450%;"><strong>{{$data["GPA"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white">Current GPA</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                        <h1 class="text-center" style="font-size: 450%"><strong>#{{$data["rank"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white">Current Rank</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                    <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                        <h1 class="text-center" style="font-size: 450%"><strong>{{$data["credits"]}}</strong></h1>
                                        <hr style="background: #fefefe">
                                        <p class="text-center text-white">Total Credits</p>
                                    </div>
                                </div>
                                <div class="px-2 pb-2 col-md-3 ">
                                <div class="p-3 card border shadow text-white bg-dark rounded">
                                        <h3 class="text-center" style="font-size: 450%"><strong>{{$data["sclass"]}}</strong></h3>
                                        <hr style="background: #fefefe">
                                <p class="text-center text-white">{{$data["class"]}}</p>
                                    </div>
                                </div>
                            </div>             
                        </div>
                    </div>
                </div>
                <div class="row pt-4">    
                    <div class="col-md-5" style="font-family:Helvetica;">
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
                                                <div class="card-header bg-dark">
                                                    <h3 class="text-white pt-3" style="font-size:calc(1.4em + 0.4vw)"> {{$pi}} Year {{$pj}} Semester</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.4em + 0.8vw);">{{$data[$gp]}} </h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> Semester GPA </h6>
                                                        </div>
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.4em + 0.8vw);">{{$data[$rank]}}</h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> Semester Rank </h6>
                                                        </div>
                                                        <div class="col text-center">
                                                            <h2 style="font-size:calc(1.4em + 0.8vw);"> {{$user->stuData->$totCredits}} </h2>
                                                            <h6 class="text-muted" style="font-size:calc(0.6em + 0.2vw)"> TotalCredits </h6>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @foreach ($data[$results] as $rs)
                                                        <div class="row ">
                                                            <div class="col-9">
                                                                <h5 style="font-size:calc(0.8em + 0.3vw)">{{$rs->course->cName}}</h5>
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
                    <div class="col-md-5">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-dark">
                                    <h3 class="text-white pt-3"> Batch Ranking </h3>
                                </div>
                                <div class="card-body">
                                    <?php $i = 1?>
                                    @foreach ($gpaData as $bt)
                                        <a href="/results/{{$bt["id"]}}/{{$bt["name"]}}" style="text-decoration: none;">
                                            <div class="row d-flex justify-content-between" style="margin-bottom: -20px;color:black">
                                                <div class="col-2">
                                                <p> <strong>{{$i}}</strong></p>  
                                                </div>
                                                <div class="col-6">
                                                    <p>  <strong>{{$bt["index"]}} </strong></p>   
                                                </div>
                                                <div class="col-4">
                                                    <p>  <strong>{{$bt["GPA"]}} </strong> </p>  
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
