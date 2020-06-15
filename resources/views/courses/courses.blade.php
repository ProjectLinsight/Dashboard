@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
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
                <hr><h1 class="text-center text-dark">Course Details </h1><hr>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card table-card shadow">
                            <div class="card-header bg-info pb-1">
                                <h4 class="text-white text-center">All Courses</h4>
                            </div>

                            <div class="card-body p-0">
                                <nav class="nav nav-tabs nav-fill">
                                    <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#CS">Computer Science</a>
                                    <a class="col-6 nav-item nav-link" data-toggle="tab" href="#IS">Information Systems</a>
                                </nav>
                                <div class="tab-content">
                                    <div id="CS" class="tab-pane fade show active">
                                        <nav class="nav nav-tabs nav-fill">
                                            <a class="col-3 nav-item nav-link active" data-toggle="tab" href="#cs1">1st Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#cs2">2nd Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#cs3">3rd Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#cs4">4th Year</a>
                                        </nav>
                                        <div class="tab-content">
                                            <?php
                                            for($i=1;$i<5;$i++){
                                                $tag = 'cs'.(string)$i ;
                                                if($i>=3){$flag = 1 ;}
                                                else {$flag =0 ;}
                                                if($i==1){$show ='show active';}
                                                else{$show = '';}
                                            ?>
                                            <div id="{{$tag}}" class="tab-pane fade {{$show}} ">                 
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Course Code </th>
                                                                <th>Name</th>
                                                                <th>Credits</th>
                                                                @if ($flag==0)      
                                                                    <th>Category</th>
                                                                @else
                                                                    <th>Hons CS</th>
                                                                    <th>Hons SE</th>
                                                                    <th>General</th>
                                                                @endif
                                                                <th>Semester</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach(${$tag} as $c)
                                                            <tr>
                                                                <td> <a href="/courses/{{$c->cid}}" style="text-decoration: none;color:black"> {{$c->cid}} </a></td>
                                                                <td> <a href="/courses/{{$c->cid}}" style="text-decoration: none;color:black"> {{$c->cName}} </a></td>
                                                                <td>{{$c->credits}}</td>
                                                                @if ($flag==0)
                                                                    <td>{{substr($c->type,0,1)}}</td>
                                                                @else 
                                                                    <td>{{substr($c->type,0,1)}}</td>
                                                                    <td>{{substr($c->type,1,1)}}</td>
                                                                    <td>{{substr($c->type,2,1)}}</td>        
                                                                @endif
                                                                <td>{{$c->semester}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            }    
                                            ?>
                                        </div>                                      
                                    </div>
                                    <div id="IS" class="tab-pane fade">
                                        <nav class="nav nav-tabs nav-fill">
                                            <a class="col-3 nav-item nav-link active" data-toggle="tab" href="#is1">1st Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#is2">2nd Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#is3">3rd Year</a>
                                            <a class="col-3 nav-item nav-link" data-toggle="tab" href="#is4">4th Year</a>
                                        </nav>
                                        <div class="tab-content">
                                            <?php
                                            for($i=1;$i<5;$i++){
                                                $tag = 'is'.(string)$i ;
                                                if($i>=3){$flag = 1 ;}
                                                else {$flag =0 ;}
                                                if($i==1){$show ='show active';}
                                                else{$show = '';}
                                            ?>
                                            <div id="{{$tag}}" class="tab-pane fade {{$show}}">                 
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0 text-center" style=" border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Course Code </th>
                                                                <th>Name</th>
                                                                <th>Credits</th>
                                                                @if ($flag==0)      
                                                                    <th>Category</th>
                                                                @else
                                                                    <th>Honours</th>
                                                                    <th>General</th>
                                                                @endif
                                                                <th>Semester</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach (${$tag} as $c)
                                                            <tr>
                                                                <td> <a href="/courses/{{$c->cid}}" style="text-decoration: none;color:black"> {{$c->cid}} </a></td>
                                                                <td> <a href="/courses/{{$c->cid}}" style="text-decoration: none;color:black"> {{$c->cName}} </a></td>
                                                                <td>{{$c->credits}}</td>
                                                                @if ($flag==0)
                                                                    <td>{{substr($c->type,0,1)}}</td>
                                                                @else 
                                                                    <td>{{substr($c->type,0,1)}}</td>
                                                                    <td>{{substr($c->type,1,1)}}</td>       
                                                                @endif
                                                                <td>{{$c->semester}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php } ?>   
                                        </div> 
                                    </div>
                                </div>
                                <hr>
                                <p class="text-center text-muted"> Please note that for the category 'X' stands for cumpulsory '0' for optional and '-'' for not available </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-success pb-1">
                                    <h4 class="text-white text-center"> Currently Enrolled Courses </h4>
                                </div>
                                <div class="card-body">
                                    axZ
                                </div>
                            </div>
                        </div>
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-secondary pb-1">
                                    <h4 class="text-white text-center"> Completed Courses </h4>
                                </div>
                                <div class="card-body">
                                    axZ
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>