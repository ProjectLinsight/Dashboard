@extends('layouts.app')
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(52,58, 64, 0.75);width:100vw;height:100vh">
    </div>
</div>
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 mt-5">
            <div class="card mt-5">
                <div class="card-header bg-dark text-white text-center pt-4"> <h4>{{ __('Reset Your Password') }}</h4></div>

                <div class="card-body text-center" style="background: #eee">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        @if(Auth::User())
                            <p class="text-muted">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                            <p class="text-muted">{{ __('If you did not receive the email') }},</p>
                            <input hidden id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                        @else
                            <p class="text-muted">{{ __('Please enter your email to send the reset link') }}</p>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
