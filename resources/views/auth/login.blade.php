<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(52, 58, 64, 0.75);width:100vw;height:100vh">
    </div>
</div>
@extends('layouts.app')

@section('content')
    <div class="container-fluid" style="display: table;position: absolute;top: 0;left: 0;height: 100%;width: 100%;">
        <div class=""  style="display: table-cell;vertical-align: middle;">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-center text-white pb-0">
                            <h4>Get Started<h4>
                        </div>
                        <div class="card-body pt-5" style="background: #eee">
                            <div class="d-flex justify-content-center" style="margin-top: -70px;margin-bottom:-40px">
                                <img src="images/logo/logo1.png" style="max-width: 250px;height:auto" alt="logo">
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row  d-flex justify-content-center">
                                    <div class="col-md-10">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row  d-flex justify-content-center">
                                    <div class="col-md-10">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row  d-flex justify-content-center">
                                    <div class="col-md-10 d-flex justify-content-center ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-center">
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-block text-white">Login</button>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-center">
                                    <div class="col-md-10 d-flex justify-content-center">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
