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
                    <h4 class="text-center pr-5">Admin Panel<h4>
                </li>
                <li class="pt-3">
                    <a href="/admin/dashboard"><i class="fas fa-home pr-2"></i>Dashboard</a>
                    <hr class="content-center" style="width:75%;background : #555">   
                </li>
                <li>
                    <a href="/admin/user"><i class="fas fa-user pr-2"></i>Manage Users</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>                
                <li>
                    <a href="/admin/results"><i class="fas fa-chart-line pr-2"></i>Manage Results</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                <a href="/admin/courses"><i class="fas fa-book pr-2"></i>Manage Courses</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/admin/analysis"><i class="fas fa-id-card pr-2"></i>Analysis</a>
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

            <div class="container-fluid row m-0" >
                <div class="col-md-7">

                </div>
                <div class="col-md-5 pb-5">
                    <div class="pb-3">
                        <div class="card table-card shadow">
                            <div class="card-header bg-info pt-3">
                                <h3 class="text-white"> Assign Lecturers</h3>
                            </div>
                            <div class="card-body p-0">
                                <script  type="application/javascript">
                                    function getId(course) {
                                        console.log(course.cid);
                                        document.getElementById("ccid").value=course.cid;
                                        document.getElementById("ccName").value=course.cName;
                                    }
                                </script>

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
                                                    <table class="table table-hover mb-0" style="border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Semester</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach(${$tag} as $c)
                                                            <tr>
                                                                <td data-toggle="modal" data-target="#exampleModalCenter" onclick="getId({{$c}})"> {{$c->cName}} </td>
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
                                                    <table class="table table-hover mb-0" style=" border-collapse: collapse;">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Semester</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach (${$tag} as $c)
                                                            <tr>    
                                                                <td data-toggle="modal" data-target="#exampleModalCenter" onclick="getId({{$c}})"> {{$c->cName}} </td>
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
                                <p class="text-muted pl-2"> *Tap on course name to assign a lecturer </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" style="width: 100%;height:auto" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Assign Lecturer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/admin/assign" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group content-center">
                        <h6 class="pl-3 text-muted"> Course ID :</h6>
                        <div class="col-md-12">
                            <input id="ccid" type="text" class="form-control" name="cid"  >
                        </div>
                    </div>
                    <div class="form-group content-center">
                        <h6 class="pl-3 text-muted"> Course Name :</h6>
                        <div class="col-md-12">
                            <input id="ccName" type="text" class="form-control" name="cName" >
                        </div>
                    </div>
                    <div class="form-group content-center">
                        <h6 class="pl-3 text-muted"> Year :</h6>
                        <div class="col-md-12">
                            <input id="year" type="number" min="2019" max="2030" value="2020" class="form-control @error('year') is-invalid @enderror" value=" {{old('year')}} " required autocomplete="Year" name="year" >
                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group content-center">
                        <h6 class="pl-3 text-muted"> Lecturer :</h6>
                        <div class="col-md-12">
                            <select name="lid" class="form-control"  value=" {{old('lid')}} " required autocomplete="Lecturer Name">                        
                                <option selected>Select Lecturer</option>
                                @foreach ($lec as $l)
                                    <option value="{{$l->index}}">{{$l->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group content-center">
                        <div class="form-group d-flex justify-content-center">
                            <div class="row col-md-12">
                                <button type="submit" class="btn btn-info btn-block text-white"> Assign </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
