@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
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
                <hr><h1 class="text-center text-dark">Course Details </h1><hr>
                <div class="col-md-7">
                    <div class="card table-card shadow">
                        <div class="card-header bg-info pb-1">
                            <h4 class="text-white">Courses</h4>
                        </div>
                        

                        <div class="card-body p-0">
                            <nav class="nav nav-tabs nav-fill">
                                <a class="col-6 nav-item nav-link active" data-toggle="tab" href="#CS">Computer Science</a>
                                <a class="col-6 nav-item nav-link" data-toggle="tab" href="#IS">Information Systems</a>
                            </nav>
                            <div class="tab-content">
                                <div id="CS" class="tab-pane fade in active">
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
                                        ?>
                                        <div id="{{$tag}}" class="tab-pane fade">                 
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
                                                            <td>{{$c->cid}}</td>
                                                            <td>{{$c->cName}}</td>
                                                            <td>{{$c->credits}}</td>
                                                            @if ($flag==0)
                                                                <td>{{$c->type}}</td>
                                                            @else 
                                                                @if ($c->type=="Compulsory")
                                                                    <td>X</td>
                                                                    <td>X</td>
                                                                    <td>X</td>
                                                                @else
                                                                    @if ($c->type=="Optional")
                                                                        <td>O</td>
                                                                        <td>O</td>
                                                                        <td>O</td>            
                                                                    @else                                                                            
                                                                        <td>
                                                                            @if(substr($c->type,3,1)=="1") X
                                                                            @else
                                                                                @if (substr($c->type,3,1)=="X") - 
                                                                                @else O 
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if(substr($c->type,4,1)=="1") X
                                                                            @else
                                                                                @if (substr($c->type,4,1)=="X") - 
                                                                                @else O 
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if(substr($c->type,5,1)=="1") X
                                                                            @else
                                                                                @if (substr($c->type,5,1)=="X") - 
                                                                                @else O 
                                                                                @endif
                                                                            @endif
                                                                        </td> 
                                                                    @endif       
                                                                @endif
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
                                        ?>
                                        <div id="{{$tag}}" class="tab-pane fade">                 
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
                                                            <td>{{$c->cid}}</td>
                                                            <td>{{$c->cName}}</td>
                                                            <td>{{$c->credits}}</td>
                                                            @if ($flag==0)
                                                                <td>{{$c->type}}</td>
                                                            @else 
                                                                @if ($c->type=="Compulsory")
                                                                    <td>X</td>
                                                                    <td>X</td>
                                                                @else
                                                                    @if ($c->type=="Optional")
                                                                        <td>O</td>
                                                                        <td>O</td>            
                                                                    @else                                                                            
                                                                        <td>
                                                                            @if(substr($c->type,2,1)=="1") X
                                                                            @else
                                                                                @if (substr($c->type,2,1)=="X") - 
                                                                                @else O 
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if(substr($c->type,3,1)=="1") X
                                                                            @else
                                                                                @if (substr($c->type,3,1)=="X") - 
                                                                                @else O 
                                                                                @endif
                                                                            @endif
                                                                        </td> 
                                                                    @endif       
                                                                @endif
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>