@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>

@section('content')
{{-- <div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(52,58, 64, 0.75);width:100vw;height:100vh">
    </div>
</div> --}}
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(225,225, 225, 0.75);width:100vw;height:100vh">
    </div>
</div>
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
                        <div class="col-md-8 ">
                            <div class="pb-3">
                                <div class="card table-card shadow">
                                    <div class="card-header bg-dark pt-3">
                                        <h4 class="text-white m-0 p-0"> Uploaded Results</h4>
                                    </div>
                                    <div class="card-body p-0" style="background: #eee">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0" style="border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        <th>Course Code</th>
                                                        <th>Course Name</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 14px">
                                                    @foreach ($results ?? '' as $rs)
                                                    <tr>
                                                        <td>{{$rs->subjectCode}}</td>
                                                        <td>{{$rs->course->cName}}</td>
                                                        <td class="m-0 pb-0 pt-2">
                                                            <form class="m-0 p-0" action="/admin/results/{{$rs->subjectCode}}/{{$rs->yoe}}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm m-0 btn-transparent">  <i class="fa fa-trash text-danger"></i> </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- @foreach ($results ?? '' as $rs)
                                <p>{{$rs->subjectCode}} - {{$rs->course->cName}}</p>

                            @endforeach --}}
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow m-0">
                                <div class="card-header bg-dark pt-3">
                                    <h4 class="text-white">Upload Results</h4>
                                </div>
                                <div class="card-body" style="background: #eee">
                                    <p class="text-muted"> Please upload a csv file with the following pattern in it. <br>
                                    1st line - "Batch, YOE, Subject Code, Semester" <br>
                                    2nd line onwards - "Index Number, Grade"</p>
                                    <hr>
                                    <form method="POST" action="/admin/results" enctype="multipart/form-data" method="POST" class="pt-2">
                                        @csrf
                                        <div class="form-group row  d-flex justify-content-center">
                                            <div class="col-md-12">
                                                <div class="custom-file">
                                                    <input type="file" id="result" style="background: #eee" class="custom-file-label form-control  @error('result') is-invalid @enderror" accept=".csv" name="result" value="{{ old('result') }}" autocomplete="result" autofocus>
                                                    <label class="custom-file-label" for="result" data-browse="Bestand kiezen">Upload Result file </label>
                                                </div>
                                                @error('result')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <div class="form-group d-flex justify-content-center pt-3">
                                                    <div class="col-md-6">
                                                        <button type="submit" class="btn btn-primary btn-block text-white">Upload Results</button>
                                                    </div>
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
@endsection
