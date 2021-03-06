@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d43d952765.js" crossorigin="anonymous"></script>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
@section('content')
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

            <div class="container-fluid" >
                <div class="row">
                    <div class="col-md-8">
                        <script type="application/javascript">
                            (function(){
                                'use strict';
                                var $ = jQuery;
                                $.fn.extend({
                                    filterTable: function(){
                                        return this.each(function(){
                                            $(this).on('keyup', function(e){
                                                $('.filterTable_no_results').remove();
                                                var $this = $(this),
                                                    search = $this.val().toLowerCase(),
                                                    target = $this.attr('data-filters'),
                                                    $target = $(target),
                                                    $rows = $target.find('tbody tr');

                                                if(search == '') {
                                                    $rows.show();
                                                }else {
                                                    $rows.each(function(){
                                                        var $this = $(this);
                                                        $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();
                                                    })
                                                }
                                            });
                                        });
                                    }
                                });
                                $('[data-action="filter"]').filterTable();
                            })(jQuery);
                        </script>

                        <div class="card table-card shadow">
                            <div class="card-header bg-dark pt-3">
                                <div class="row d-flex justify-content-between m-0">
                                    <div class="col-md-8 m-0">
                                        <h4 class="text-white m-2 p-0"> User Information </h4>
                                    </div>
                                    <div class="col-md-4 m-0">
                                        <input type="text" class="form-control m-0" style="background: #eee" id="task-table-filter" data-action="filter" data-filters="#task-table" placeholder="Search..." />
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive" style="background: #eee">
                                <table id=task-table class="table table-hover mb-0 text-center" style="border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th> Name </th>
                                            <th>Email Address</th>
                                            <th> User Type </th>
                                            <th> Delete
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div id="Default" style="display: none;">
                                            <p>dsfsad </p>
                                        </div>
                                        <div>
                                            @foreach ($users as $user)
                                            <tr style="font-size: 14px">
                                                <td>{{$user['name']}}</td>
                                                <td>{{$user['email']}}</td>
                                                <td>{{$user['utype']}}</td>
                                                <td class="m-0 pb-0 pt-2">
                                                    <form class="m-0 p-0" action="/admin/{{$user['id']}}/delete" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm m-0 btn-transparent">  <i class="fa fa-trash text-danger"></i> </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="pb-4">
                            <div class="card shadow">
                                <div class="card-header bg-dark pt-3">
                                    <h4 class="text-white p-0 m-0"> Bulk user upload</h4>
                                </div>
                                <div class="card-body px-3" style="background: #eee">
                                    <h6 class="text-muted pb-2 text-justify text-center">
                                        Upload the csv file with the pattern of "email, user type,password,index" in each row.
                                    </h6>
                                    <form method="POST" action="/admin/user" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="form-group row  d-flex justify-content-center mb-0 pb-0">
                                            <div class="col-md-12">
                                                <div class="custom-file">
                                                    <input type="file" id="users" style="background: #eee" class="custom-file-label form-control  @error('users') is-invalid @enderror" accept=".csv" name="users" value="{{ old('users') }}" autocomplete="users" autofocus>
                                                    <label class="custom-file-label" for="users" data-browse="Bestand kiezen">Upload Userdata file </label>
                                                </div>
                                                @error('users')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <div class="form-group d-flex justify-content-center pt-3 mb-0">
                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-primary btn-block text-white">Register users</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="pb-3">
                            <div class="card shadow">
                                <div class="card-header bg-dark pt-3">
                                    <h4 class="text-white p-0 m-0"> Add user manually</h4>
                                </div>
                                <div class="card-body px-2 pt-3" style="background: #eee">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-10 ">
                                                <input id="name" type="text" style="background: #eee" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="User Name" autofocus>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-10 ">
                                                <input id="email" style="background: #eee" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
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

                                        <div class="form-group d-flex justify-content-center m-0">
                                            <div class="col-md-11">
                                                <select onchange="getType(this);" style="background: #eee" name="utype" id="utype" class="form-control @error('credits') is-invalid @enderror"  value=" {{old('utype')}} " required autocomplete="User Type">
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
                                        </div>


                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-10" id="ifYes" style="display: none;background: #eee">
                                                <input id="index" type="text" class="form-control @error('index') is-invalid @enderror" name="index" value="{{ old('index') }}" autocomplete="index" placeholder="Index Number">
                                                @error('index')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-10 ">
                                                <input id="password" style="background: #eee" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-10 ">
                                                <input id="password-confirm" style="background: #eee" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                            </div>
                                        </div>

                                        <div class="form-group row d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <button type="submit" class="btn btn-primary btn-block text-white">Register User</button>
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
