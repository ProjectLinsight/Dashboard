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
                    <a href="#"><i class="fas fa-id-card pr-2"></i>Contact</a>
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

            <div class="container-fluid m-0" >
                <div class="row">
                    <div class="col-md-10 pl-5 pb-4">
                        <div class="card bg-dark" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                            <div class="p-3 row rounded"> 
                                <div class="col-md-1">
                                    <img class="rounded-circle border" style="max-width: 60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                </div>
                                <div class="col-md-11 text-white">
                                    <div class="row d-flex justify-content-between align-items-baseline">
                                        <h5 class="pl-3"><strong>{{$user->name}}</strong></h5>
                                    </div>
                                    <div class="row pl-3">
                                        <h6  style="font-size: 75%"> Index : {{$user->index}} | Last-updated : {{$user->StuData->updated_at}}</h6>
                                    </div>
                                    <hr style="background: white">
                                    <div class="row pt-2 pb-3 px-3 d-flex justify-content-center"  style="font-family:Helvetica;">
                                        <div class="px-2 col-md-3 ">
                                            <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                                <h1 class="text-center" style="font-size: 450%;"><strong>{{$data["GPA"]}}</strong></h1>
                                                <hr style="background: #fefefe">
                                                <p class="text-center text-white">Current GPA</p>
                                            </div>
                                        </div>
                                        <div class="px-2 col-md-3 ">
                                            <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                                <h1 class="text-center" style="font-size: 450%"><strong>#{{$data["rank"]}}</strong></h1>
                                                <hr style="background: #fefefe">
                                                <p class="text-center text-white">Current Rank</p>
                                            </div>
                                        </div>
                                        <div class="px-2 col-md-3 ">
                                            <div class="p-3 card border shadow text-white bg-dark rounded" style="background: #fefefe">
                                                <h1 class="text-center" style="font-size: 450%"><strong>{{$data["credits"]}}</strong></h1>
                                                <hr style="background: #fefefe">
                                                <p class="text-center text-white">Total Credits</p>
                                            </div>
                                        </div>
                                        <div class="px-2 col-md-3 ">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 pb-5 px-5" style="font-family:Helvetica;">
                        @if ($data["results42"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 4th Year 2nd Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp42"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank42"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits42}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results42"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results41"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 4th Year 1st Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp41"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$data["rank41"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits41}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results41"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results32"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 3rd Year 2nd Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp32"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank32"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits32}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results32"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results31"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 3rd Year 1st Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp31"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank31"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits31}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results31"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results22"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 2nd Year 2nd Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp22"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank22"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits22}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results22"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results21"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 2nd Year 1st Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp21"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank21"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits21}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results21"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results12"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 1st Year 2nd Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp12"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank12"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits12}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results12"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($data["results11"]!==null)
                            <div class="pb-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header bg-dark">
                                        <h3 class="text-white pt-3"> 1st Year 1st Semester</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["gp11"]}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester GPA </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;">{{$data["rank11"]}}</h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Rank </h6>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h2 style="font-family:Helvetica;"> {{$user->stuData->totCredits11}} </h2>
                                                <h6 class="text-muted" style="font-size: 75%"> Semester Credits </h6>
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach ($data["results11"] as $rs)
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <h5>{{$rs->course->cName}}</h5>
                                                    <p class="text-muted" style="font-size: 75%">{{$rs->subjectCode}} / {{$rs->course->credits}} / year of examination : {{$rs->yoe}}</p> 
                                                </div>
                                                <div class="col-md-2">
                                                    <h2 class="font-weight-bold text-dark">{{$rs->grade}}</h2>
                                                </div>
                                            </div> 
                                            <hr style="margin-top: -5px">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-5">
                        <div class="pb-3">
                            <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                <div class="card-header bg-dark">
                                    <h3 class="text-white pt-3"> Batch Ranking </h3>
                                </div>
                                <div class="card-body">
                                    <?php $i = 1?>
                                    @foreach ($gpaData as $bt)
                                        <a href="/results/{{$bt["id"]}}/{{$bt["name"]}}" style="text-decoration: none;">
                                            <div class="row d-flex justify-content-between px-5" style="margin-bottom: -20px;color:black">
                                                <div class="col-md-2">
                                                <p> <strong>{{$i}}</strong></p>  
                                                </div>
                                                <div class="col-md-8">
                                                    <p>  <strong>{{$bt["index"]}} </strong></p>   
                                                </div>
                                                <div class="col-md-2">
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
