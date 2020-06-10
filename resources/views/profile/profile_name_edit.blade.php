@extends('layouts.app')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script>
@section('content')
<div class="container-fluid pt-4">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit your Profile Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
          <form method="POST" action="/user/{{$user->id}}/update" enctype="multipart/form-data" method="POST">  
      @csrf
                    @method('PATCH')
   
                    <div class="form-group d-flex justify-content-center">
                    <div class="col-md-12">
                    <h6 style="font-size:calc(0.8em + 0.2vw)"><strong> {{$user->year}}</strong></h6>
                            <input id="name" type="name" class="form-control @error('title') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="{{$user->name}}" autofocus placeholder="{{$user->name}}">
                            @error('title')
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
