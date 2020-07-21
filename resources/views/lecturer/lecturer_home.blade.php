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
                                <!-- <h6 class="text-white"> <a  href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/overview">Assignment & Quiz</a></h6> -->
                            </div>
                        @endforeach
                    </div>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                <a href="/profile/{{Auth::user()->id}}/{{Auth::user()->name}}"><i class="fas fa-user pr-2"></i>Profile</a>
                    <hr class="content-center" style="width:75%;background : #555">
                </li>
                <li>
                    <a href="/student_enrollment"><i class="fas fa-id-card pr-2"></i>Student Entrollment</a>
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

            <div class="container-fluid row m-0 changeList"  >
                <div class="col-md-8 py-3">
                    <hr>
                    <h1 class="text-center text-dark"> <strong>Timeline </strong> </h1>
                    <hr>
                    <?php $post = App\Post::all() ?>
                    @foreach ($post as $post)
                    <div class="pb-4">
                        <div class="p-3 rounded shadow" style="background:white;">
                            <div class="row d-flex justify-content-between">
                                <div class=" col-10 d-flex">
                                    <div class="p-2">
                                        <img class="rounded-circle" style="max-width: 60px;height:60px"src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="Generic placeholder image">
                                    </div>
                                    <div class="col-8">
                                        <div class="row d-flex justify-content-between align-items-baseline">
                                            <div>
                                                <h5 class="pt-3" style="font-size:calc(1em + 0.4vw)"><strong>{{$post->user->name}}</strong></h5>
                                                @if ($post->created_at!==$post->updated_at)
                                                    <h6 class="text-muted " style="font-size:calc(0.6em + 0.1vw)" data-toggle="tooltip" title="post created : {{$post->created_at}}">  {{$post->updated_at}}</h6>     
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="p-3 border rounded" style="background: #fefefe">
                                <h5  style="font-size:calc(1.2em + 0.2vw)"><strong>{{ $post->title}}</strong></h5>
                                <hr>
                                <p style="font-size:calc(0.9em + 0.1vw);text-align: justify">{{$post->description}}</p>
                                <div class="d-flex justify-content-center">
                                <img style="max-height: 400px;" src="uploads/post/{{ $post->image }}" alt="">
                               
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-4 pb-3">
                    <div class="p-3 row rounded d-flex justify-content-center shadow" style="background:white">
                        <div class="col-4 pt-4 ">
                            <img class="rounded-circle"  style="max-width: 140px;width:100%;height:auto" src="https://mdbootstrap.com/img/Photos/Avatars/img (27).jpg" alt="">    
                            @if (Auth::user()->id === Auth::user()->id)
                                <p class="pt-2 text-center"><a href="" style="font-size:calc(0.8em + 0.1vw)"> Edit Photo</a></p>
                                @if (Auth::user()->name==="Anonymous User")
                                    <p class="text-center" style="margin-top:-10px"><a href="/user/{{$user->id}}/edit" style="font-size:calc(0.8em + 0.1vw);"> Setup Username </a></p>
                                @endif
                            @endif
                        </div>  
                        <div class="col-8 pl-3 pt-4">
                            <h3 style="font-size:calc(1.3em + 0.4vw)"> <strong> {{Auth::user()->name}}</strong> </h3>
                            <h6 class="text-muted" style="font-size:calc(0.8em + 0.2vw)"> {{Auth::user()->email}}</h6>
                            <hr>
                            <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> {{Auth::user()->posts->count()}} interactions </strong></h6>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                              <!--   <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> B.Sc. in {{Auth::user()->degree}}</strong></h6>
                                    <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> {{Auth::user()->year}}</strong></h6> -->
                                </div>
                            </div>
                        </div>
                        <hr style="width: 93%">
                        <div class="col-md-12">
                            <h4 style="font-size:calc(1.1em + 0.4vw)"> <strong>Currently Assigned Courses </strong></h4>
                        </div>
                        <div class="col-12 pl-4">
                        @foreach (Auth::user()->lecAssigning as $item)
                            <a href="/lecturer/{{Auth::user()->id}}/{{$item->cid}}/courses">{{$item->cid}}</a> <br>
                        @endforeach
                        </div> 
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>







{{-- Modal for write post --}}
<div class="modal fade" style="width: 100%;height:auto" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <label class="custom-file-label" for="image" data-browse="Bestand kiezen">Upload image (optional) </label>
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

@endsection
