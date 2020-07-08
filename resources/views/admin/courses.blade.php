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

            <div class="container-fluid row m-0 changeList" >
                <div class="col-md-12 pb-5">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="pb-3">
                                <div class="card table-card shadow">
                                    <div class="card-header bg-info pt-3  text-white">
                                        <h3> All Courses</h3>
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
                                                                        <td>
                                                                        <button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#exampleModalCenter" onclick="getId({{$c}})">
                                                                            <h7 class="pt-2"> Update <h7>
                                                                        </button>
                                                                        </td>                                                                    
                                                                        <td>
                                                                        <p> <a href = "/admin/courses_delete/{{ $c->cid }}" class = "btn btn-danger btn-xs" role = "button"> Delete </a> </p>
                                                                        </td>
                                                                        
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
                                                                       <td>
                                                                        <button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#exampleModalCenter" onclick="getId({{$c}})">
                                                                            <h7 class ="pt-2"> Update <h7>
                                                                        </button>
                                                                        </td> 
                                                                        <!-- <td data-toggle="modal" data-target="#exampleModalCenter" onclick="getId({{$c}})">
                                                                        <p> <a href = "#" class = "btn btn-secondary btn-xs" role = "button"> Update </a> </p>
                                                                        </td> -->
                                                                        <td>
                                                                        <p> <a href = "/admin/courses_delete/{{ $c->cid }}" class = "btn btn-danger btn-xs" role = "button" > Delete </a> </p>
                                                                        </td>
                                                                        
                                                                        
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
                        </div>
                        <div class="col-md-3">
                            <div class="pb-3">
                                <div class="card shadow"  >
                                    <div class="card-header bg-info pt-3 text-center text-white">
                                        <h3> Add New Course</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="/admin/courses/" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="form-group content-center">
                                                <h6 class="pl-3 text-muted"> Course ID :</h6>
                                                <div class="col-md-12">
                                                    <input id="cid" type="text" class="form-control @error('cid') is-invalid @enderror" name="cid" value=" {{old('cid')}} " required autocomplete="cid" autofocus placeholder="Course ID">
                                                    @error('cid')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group content-center">
                                                <h6 class="pl-3 text-muted"> Course Name :</h6>
                                                <div class="col-md-12">
                                                    <input id="cName" type="text" class="form-control @error('cName') is-invalid @enderror" name="cName" value=" {{old('cName')}} " required autocomplete="Course Name" autofocus placeholder="Course Name">
                                                    @error('cName')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group content-center">
                                                <h6 class="pl-3 text-muted"> Course Credits :</h6>
                                                <div class="col-md-12">
                                                    <input id="credits" type="number" class="form-control @error('credits') is-invalid @enderror" name="credits" value=" {{old('credits')}} " required autocomplete="Course Credits" autofocus >
                                                    @error('credits')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                
                                            <div class="form-group content-center">
                                                <h6 class="pl-3 text-muted"> Course Type :</h6>
                                                <div class="col-md-12">
                                                    <select name="type" id="type" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('type')}} " required autocomplete="Course Type">
                                                        <option selected></option>
                                                        <option value="Compulsory">Compulsory For All</option>
                                                        <option value="Optional">Optional For All</option>
                                                        <option value="IS1X ">IS Honours Only</option>
                                                        <option value="ISX1">IS General Only</option>
                                                        <option value="IS0X ">IS Honours Optional </option>
                                                        <option value="ISX0">IS General Optional </option>
                                                        <option value="IS10">IS Honours Compulsory / Gen-Optional </option>
                                                        <option value="IS01">IS General Compulsory / Hon-Optional </option>
                                                        <option value="CS11X">CS & SE Only</option>
                                                        <option value="CS110">CS & SE Compulsory / Gen-Optional </option>
                                                        <option value="CS1X1">CS & Gen Only </option>
                                                        <option value="CS101">CS & Gen Compulsory / SE-Optional </option>
                                                        <option value="CSX11">SE & Gen Only </option>
                                                        <option value="CS011">SE & Gen Compulsory / CS-Optional </option>
                                                        <option value="CS1XX">CS Honours Only</option>
                                                        <option value="CSX1X">SE Honours Only</option>
                                                        <option value="CSXX1">CS General Only</option>
                                                        <option value="CS0XX">CS Honours Opt</option>
                                                        <option value="CSX0X">SE Honours Opt</option>
                                                        <option value="CSXX0">CS General Opt</option>
                                                        <option value="CS100">CS Compulsory / SE & Gen Optional </option>
                                                        <option value="CS10X">CS Compulsory / SE Optional </option>
                                                        <option value="CS1X0">CS Compulsory / Gen Optional </option>
                                                        <option value="CS010">SE Compulsory / CS & Gen Optional </option>
                                                        <option value="CS01X">SE Compulsory / CS Optional </option>
                                                        <option value="CSX10">SE Compulsory / Gen Optional </option>
                                                        <option value="CS001">Gen Compulsory / CS & SE Optional </option>
                                                        <option value="CSX01">Gen Compulsory / SE Optional </option>
                                                        <option value="CS0X1">Gen Compulsory / CS Optional </option>
                                                    </select>
                                                    @error('type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="form-group content-center">
                                                <h6 class="pl-3 text-muted"> Course Semester :</h6>
                                                <div class="col-md-12">
                                                    <select name="semester" id="semester" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('semester')}} " required autocomplete="semester">
                                                        <option selected></option>
                                                        <option value="One">One</option>
                                                        <option value="Two">Two</option>
                                                        <option value="Spanned">Spanned</option>
                                                    </select>
                                                    @error('semester')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                
                                            <div class="form-group content-center">
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="row col-md-12">
                                                        <button type="submit" class="btn btn-info btn-block text-white">Add Course </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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

{{-- Modal for update courses --}}
<div class="modal fade" style="width: 100%;height:auto" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Update Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
               <form method="POST" action="/admin/courses_update/{{$c->cid}}" enctype="multipart/form-data" method="POST" >
                          @csrf
                                                <div class="form-group content-center">
                                                    <h6 class="pl-3 text-muted"> Course ID :</h6>
                                                    <div class="col-md-12">
                                                        <input id="cid" type="text" class="form-control @error('cid') is-invalid @enderror" name="cid"  required autocomplete="cid" autofocus placeholder="Course ID">
                                                        @error('cid')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group content-center">
                                                    <h6 class="pl-3 text-muted"> Course Name :</h6>
                                                    <div class="col-md-12">
                                                        <input id="cName" type="text" class="form-control @error('cName') is-invalid @enderror" name="cName" value=" {{ $c->cName}} " required autocomplete="Course Name" autofocus placeholder="Course Name">
                                                        @error('cName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group content-center">
                                                    <h6 class="pl-3 text-muted"> Course Credits :</h6>
                                                    <div class="col-md-12">
                                                        <input id="credits" type="number" class="form-control @error('credits') is-invalid @enderror" name="credits" value=" {{old('credits')}} " required autocomplete="Course Credits" autofocus >
                                                        @error('credits')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                    
                                                <div class="form-group content-center">
                                                    <h6 class="pl-3 text-muted"> Course Type :</h6>
                                                    <div class="col-md-12">
                                                        <select name="type" id="type" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('type')}} " required autocomplete="Course Type">
                                                            <option selected></option>
                                                            <option value="Compulsory">Compulsory For All</option>
                                                            <option value="Optional">Optional For All</option>
                                                            <option value="IS1X ">IS Honours Only</option>
                                                            <option value="ISX1">IS General Only</option>
                                                            <option value="IS0X ">IS Honours Optional </option>
                                                            <option value="ISX0">IS General Optional </option>
                                                            <option value="IS10">IS Honours Compulsory / Gen-Optional </option>
                                                            <option value="IS01">IS General Compulsory / Hon-Optional </option>
                                                            <option value="CS11X">CS & SE Only</option>
                                                            <option value="CS110">CS & SE Compulsory / Gen-Optional </option>
                                                            <option value="CS1X1">CS & Gen Only </option>
                                                            <option value="CS101">CS & Gen Compulsory / SE-Optional </option>
                                                            <option value="CSX11">SE & Gen Only </option>
                                                            <option value="CS011">SE & Gen Compulsory / CS-Optional </option>
                                                            <option value="CS1XX">CS Honours Only</option>
                                                            <option value="CSX1X">SE Honours Only</option>
                                                            <option value="CSXX1">CS General Only</option>
                                                            <option value="CS0XX">CS Honours Opt</option>
                                                            <option value="CSX0X">SE Honours Opt</option>
                                                            <option value="CSXX0">CS General Opt</option>
                                                            <option value="CS100">CS Compulsory / SE & Gen Optional </option>
                                                            <option value="CS10X">CS Compulsory / SE Optional </option>
                                                            <option value="CS1X0">CS Compulsory / Gen Optional </option>
                                                            <option value="CS010">SE Compulsory / CS & Gen Optional </option>
                                                            <option value="CS01X">SE Compulsory / CS Optional </option>
                                                            <option value="CSX10">SE Compulsory / Gen Optional </option>
                                                            <option value="CS001">Gen Compulsory / CS & SE Optional </option>
                                                            <option value="CSX01">Gen Compulsory / SE Optional </option>
                                                            <option value="CS0X1">Gen Compulsory / CS Optional </option>
                                                        </select>
                                                        @error('type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group content-center">
                                                    <h6 class="pl-3 text-muted"> Course Semester :</h6>
                                                    <div class="col-md-12">
                                                        <select name="semester" id="semester" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('semester')}} " required autocomplete="semester">
                                                            <option selected></option>
                                                            <option value="One">One</option>
                                                            <option value="Two">Two</option>
                                                            <option value="Spanned">Spanned</option>
                                                        </select>
                                                        @error('semester')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                    
                                                <div class="form-group content-center">
                                                    <div class="form-group d-flex justify-content-center">
                                                        <div class="row col-md-12">
                                                            <button type="submit" class="btn btn-info btn-block text-white">Update Course </button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>  
                    
            </div>
        </div>
    </div>
</div>


@endsection
