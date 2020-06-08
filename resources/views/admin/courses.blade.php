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
                    <a href="#"><i class="fas fa-id-card pr-2"></i>Contact</a>
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
                <div class="col-md-12 pb-5">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="p-3">
                                <div class="card" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header text-center bg-dark text-white" >
                                        <h3 class="pt-3"> Available Courses</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table" id="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Course Id</th>
                                                    <th class="text-center">Course Name</th>
                                                    <th class="text-center">Credits</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Stream</th>
                                                    <th class="text-center">Year</th>
                                                    <th class="text-center">Semester</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $crs)
                                                <tr class="text-center">
                                                    <td> {{$crs->cid}} </td>
                                                    <td> {{$crs->cName}}  </td>
                                                    <td> {{$crs->credits}} </td>
                                                    <td> {{$crs->type}} </td>
                
                                                    @if (substr($crs['cid'],0,1)==='I')
                                                        <td> {{substr($crs['cid'],0,2)}} </td>
                                                        <td> {{substr($crs['cid'],2,1)}}</td>        
                                                    @elseif(substr($crs['cid'],0,1)==='S')
                                                        <td> {{substr($crs['cid'],1,2)}} </td>
                                                        <td> {{substr($crs['cid'],3,1)}}</td>        
                                                    @else    
                                                        <td>EN</td>
                                                        @if (substr($crs['cid'],2,1)==='H')
                                                            <td>{{substr($crs['cid'],3,1)}}</td>
                                                        @else
                                                        <td>{{substr($crs['cid'],2,1)}}</td>
                                                        @endif
                                                        
                                                    @endif
                                                    <td> {{$crs->semester}}</td>
                                                </tr>
                                                @endforeach  
                                            </tbody>
                                        </table>       
                                    </div>              
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="card"  style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                                    <div class="card-header text-center bg-dark text-white" >
                                        <h3 class="pt-3"> Add New Course</h3>
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

@endsection
