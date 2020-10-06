@extends('layouts.app')

@section('content')
<div style="background-image:url('https://www.creativeclique.co.za/wp-content/uploads/2019/01/Ridge-Design-Website-Design-Background.jpg');position: fixed;background-repeat: no-repeat;background-position: center;background-attachment: fixed;background-size: cover;height:100vh">
    <div style="background: rgba(52,58, 64, 0.75);width:100vw;height:100vh">
    </div>
</div>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-dark text-white text-center pt-4"> <h4>{{ __('Verify Your Email Address') }}</h4></div>

                <div class="card-body text-center" style="background: #eee">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p class="text-muted">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p class="text-muted">{{ __('If you did not receive the email') }},</p>
                    {{-- <form class="d-inline" method="POST" action="{{ route('verification.resend') }}"> --}}
                        {{-- @csrf --}}
                        <button type="submit" class="btn btn-outline-primary align-baseline">{{ __('click here to request another') }}</button>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
