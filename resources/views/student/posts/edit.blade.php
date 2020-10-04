@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
@section('content')
<div class="container-fluid pt-4">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit your Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="/post/{{$post->id}}/{{$post->user_id}}/update" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12">
                            <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value=" {{old('title') ?? $post->title}} " required autocomplete="title" autofocus placeholder="Title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12 px-0"> 
                            <label for="sel1">Select course:</label>
                                <select class="form-control" id="sel1" name="course_code" required autocomplete="course_code" autofocus placeholder="Course code">
                                    @foreach (Auth::user()->stu_enrollment as $sub)
                                         <option>&emsp; {{$sub->cid}}</option>
                                     @endforeach
                                 </select>
               
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                        <textarea id="description" type="text" style="height: 110px;" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus> {{$post->description}} </textarea>
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
                                <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $post->image }}" autocomplete="image" autofocus>
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

@endsection
