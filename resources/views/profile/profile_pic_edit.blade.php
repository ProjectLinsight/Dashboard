@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
@section('content')
<div class="container-fluid pt-4">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit your Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
      <!--     <form method="POST" action="/post/{{$post->id}}/{{$post->user_id}}/update" enctype="multipart/form-data" method="POST">  -->
                    @csrf
                    @method('PATCH')
   
                    <div class="form-group row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="custom-file">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Name:</label>
                                <input class="form-control" type="text" name="name" value="{{$user->name}}" placeholder="Enter your name">
                               <!--     <input type="file" id="image" class="custom-file-label form-control  @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $post->image }}" autocomplete="image" autofocus>  -->
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
