@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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

            <div class="container-fluid row m-0"  >
                <div class="col-md-8 pb-5 px-5">
                    @foreach ($user->posts as $post)
                    <div class="pb-3">
                        <div class="p-3 row rounded" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                            <div class="col-md-1 pt-3">
                                <img class="rounded-circle" style="max-width: 60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                            </div>
                            <div class="col-md-11">
                                <div class="row d-flex justify-content-between align-items-baseline">
                                    <h5 class="pl-3"><strong>{{ $user->name}}</strong></h5>
                                    @if ($user->id === Auth::user()->id)
                                        <h5 class="pr-3 pt-3"> <a href="/post/{{$post->id}}/{{$post->user_id}}/edit"><i class="fas fa-edit"></i></a></h5>
                                    @endif
                                </div>
                                <div class="row pl-3">
                                    @if ($post->created_at!==$post->updated_at)
                                        <h6 class="text-muted" data-toggle="tooltip" title="post created : {{$post->created_at}}">  {{$post->updated_at}}</h6>

                                    @else 
                                               
                                    @endif
                                    
                                </div>
                                <div class="p-3 border rounded" style="background: #fefefe">
                                    <h5><strong>{{ $post->title}}</strong></h5>
                                    <hr>
                                    <p style="text-align: justify">{{$post->description}}</p>
                                    <div class="d-flex justify-content-center">
                                    <img style="max-height: 400px;" src="/storage/{{$post->image}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="col-md-4">
                    <div class="p-3 row rounded d-flex justify-content-center" style="background:white;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 6px 0 rgba(0, 0, 0, 0.19);">
                        <div class="col-md-4 pt-4 ">
                            <img class="rounded-circle"  style="max-width: 140px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="">    
                            @if ($user->id === Auth::user()->id)
                                <p class="pt-2 text-center"><a href=""> Edit Photo</a></p>
                                @if ($user->name==="Sample name")
                                    <p class="text-center"><a href=""> Setup the username </a></p>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-8 pl-3 pt-4">
                            <h3> <strong>{{$user->name}}</strong> </h3>
                            <h6 class="text-muted"> {{$user->email}}</h6>
                            <hr>
                            <h6><strong> {{$user->posts->count()}} interactions </strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6> Degree : </h6>
                                    <h6> Batch : </h6>
                                </div>
                                <div class="col-md-8">
                                    <h6><strong> B.Sc. in {{$user->degree}}</strong></h6>
                                    <h6><strong> {{$user->year}}</strong></h6>
                                </div>
                            </div>
                        </div>
                        
                        <hr style="width: 93%">
                        <div class="col-md-12">
                            <h4> Currently Enrolled Courses</h4>
                        </div>
                        <div class="pl-5 col-md-12" >
                            <a href="#"> IS3101 - Enterprise Resource Planning Systems </a> <br>
                            <a href="#"> IS3102 - Software Quality Assuarance </a> <br>
                            <a href="#"> IS3103 - Human Computer Interaction </a> <br>
                            <a href="#"> IS3105 - Professional Practice</a> <br>
                            <a href="#"> IS3108 - Middleware Architecture</a> <br>
                            <a href="#"> IS3110 - Research Methods</a> <br>
                            <a href="#"> IS3113 - Group Project II</a> <br>
                            <a href="#"> IS3116 - Database Management Systems II</a> <br>
                            <a href="#"> IS3117 - Machine Learning and Neural Computing </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





{{-- Modal for write post --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Post Something</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/post" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12">
                            <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <textarea id="description" type="text" style="height: 110px;" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Description"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>
                                <label class="custom-file-label" for="image" data-browse="Bestand kiezen">Upload an image (optional) </label>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group d-flex justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block text-white">Share Post</button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit your Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/post" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12">
                            <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }} ?? $post->title" required autocomplete="title" autofocus placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                        <textarea id="description" type="text" style="height: 110px;" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description" autofocus placeholder="Description">{{ $post->title}}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>
                                <label class="custom-file-label" for="image" data-browse="Bestand kiezen">Edit image </label>
                            </div>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group d-flex justify-content-center">
                        <div class="row col-md-12">
                                <button type="submit" class="btn btn-info btn-block text-white">Edit </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div> --}}









@endsection
