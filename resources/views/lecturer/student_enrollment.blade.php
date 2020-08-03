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
                    <a href="/lecturer/lecturer_home"><i class="fas fa-home pr-2"></i>Feed</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a data-toggle="collapse" href="#courses" ><i class="fas fa-user pr-2"></i>Courses</a>
                    <div class="collapse pt-3 pl-5" id="courses">
                        @foreach (Auth::user()->lecAssigning as $item)
                            <h6 class="text-white">
                                <a data-toggle="collapse" href="#{{$item->cid}}"  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">{{$item->cid}}</a>
                            </h6>
                            <div class="collapse pt-0 pl-3" id="{{$item->cid}}">
                                <h6 class="text-white"> <a href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">Update</a></h6>
                                <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Analytics</a></h6>
                                <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Best Performances</a></h6>
                            </div>     
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student_enrollment"><i class="fas fa-id-card pr-2"></i>Student Data</a>
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

<!---------------------------------------------------------------------------------------------------------------------------------------------------------------->
            <div class="container-fluid row m-0" >
                <div class="col-md-12 pb-5">
                    <div class="row justify-content-center ">
                        <div class="col-md-4">
                            
                            @foreach (Auth::user()->lecAssigning as $item)
                                <h5>{{$item->cid}}</h5>
                                <h5>{{$item->course->cName}}</h5>
                            @endforeach                
                        </div>

                        {{-- <div class="col-md-8 px-5">
                            <div class="card shadow">
                                <div class="card-header bg-dark text-center text-white pt-3">
                                    <h2 class="py-3"> Students Enrollment <h2>
                                </div>
                                <div class="card-body p-5">
                                    <div class="row">
                                        <div class="col-md-6 border-right">
                                            <h4 class="text-center text-dark pb-3"> Add student manually</h4>
                                            <hr>
                                            <form method="POST" action="/lecturer/enrollment" enctype="multipart/form-data" method="POST">
                                            
                                                @csrf
        
                                                <div class="form-group row d-flex justify-content-center">
                                                    <div class="col-md-10 ">
                                                        <input id="cid" type="text" class="form-control @error('cid') is-invalid @enderror" name="cid"  autofocus placeholder="Course ID">  
                                                         @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row d-flex justify-content-center">
                                                    <div class="col-md-10 ">
                                                    <input id="index" type="text" class="form-control @error('index') is-invalid @enderror" name="index"  autofocus placeholder="Index No">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            
                                              <!--
        
                                                <div class="form-group d-flex justify-content-center">
                                                    <div class="col-md-11">
                                                        <select onchange="getType(this);" name="utype" id="utype" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('utype')}} " required autocomplete="User Type">
                                                            <option selected>Course ID</option>
                                                            <option value="Student">IS 2110</option>
                                                            <option value="Lecturer">IS 3102</option>
                                                            <option value="Admin">IS 3105</option>
                                                        </select>
                                                        @error('utype')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                                                                                      
                                               
                                                <div class="form-group row d-flex justify-content-center">
                                                    <div class="col-md-10 ">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                                    </div>
                                                </div>   -->
        
                                                <div class="form-group row d-flex justify-content-center">
                                                    <div class="col-md-6 ">
                                                        <button type="submit" class="btn btn-info btn-block text-white">Enroll</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>




                                    <div class="col-md-6">
                                        <h4 class="text-center text-dark pb-3"> Add bulk student </h4>
                                        <hr>
                                        <h6 class="text-muted pb-4 text-justify text-center">
                                            Upload the csv file with the pattern of "index,course-id" in each row.
                                        </h6>
                                        <form method="POST" action="/admin/user" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <div class="form-group row  d-flex justify-content-center">
                                                <div class="col-md-12">
                                                    <div class="custom-file">
                                                        <input type="file" id="users" class="custom-file-label form-control  @error('users') is-invalid @enderror" accept=".csv" name="users" value="{{ old('users') }}" autocomplete="users" autofocus>
                                                        <label class="custom-file-label" for="users" data-browse="Bestand kiezen">Upload file </label>
                                                    </div>
                                                    @error('users')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <div class="form-group d-flex justify-content-center pt-3">
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-info btn-block text-white">Enroll</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                          
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
