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
            <div class="container-fluid">
                <div class="row justify-content-center ">
                    <div class="col-md-6">
                        <h1>wcdsd</h1>
                    </div>
                    <div class="col-md-3 pb-3">
                        <div class="card shadow" >
                            <div class="card-header bg-info text-center text-white pt-3">
                                <h3> Add Users Manually <h3>
                            </div>
                            <div class="card-body px-5">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <div class="form-group row d-flex justify-content-center">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="User Name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group row d-flex justify-content-center">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <script  type="application/javascript">
                                        function getType(that) {
                                            if (that.value == "Student") {
                                                document.getElementById("ifYes").style.display = "block";
                                            }else{
                                                document.getElementById("ifYes").style.display = "none";
                                            }
                                        }
                                    </script>

                                    <div class="form-group m-0">
                                        <select onchange="getType(this);" name="utype" id="utype" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('utype')}} " required autocomplete="User Type">
                                            <option selected>User Type</option>
                                            <option value="Student">Student</option>
                                            <option value="Lecturer">Lecturer</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        @error('utype')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    

                                    <div class="form-group row d-flex justify-content-center">
                                        <div id="ifYes" style="display: none;">
                                            <input id="index" type="text" class="form-control @error('index') is-invalid @enderror" name="index" value="{{ old('index') }}" autocomplete="index" placeholder="Index Number">
                                            @error('index')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                
                                    
                                    <div class="form-group row d-flex justify-content-center">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row d-flex justify-content-center">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                    </div>

                                    <div class="form-group row d-flex justify-content-center">
                                        <div class="col-md-6 ">
                                            <button type="submit" class="btn btn-info btn-block text-white">Register User</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 pb-3">
                        <div class="card shadow" >
                            <div class="card-header bg-info text-center text-white pt-3">
                                <h3> Add Bulk Users <h3>
                            </div>
                            <div class="card-body">
                                <h6 class="text-muted pb-4 text-justify text-center">
                                    Upload the csv file with the pattern of "email, user type,password,index" in each row.
                                </h6>
                                <form method="POST" action="/admin/user" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="custom-file">
                                        <input required type="file" id="users" class="custom-file-label form-control  @error('users') is-invalid @enderror" accept=".csv" name="users" value="{{ old('users') }}" autocomplete="users" autofocus>
                                        <label class="custom-file-label" for="users" data-browse="Bestand kiezen">Upload Userdata file </label>
                                    </div>
                                    @error('users')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-group d-flex justify-content-center pt-3">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-info btn-block text-white">Register users</button>
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
@endsection

