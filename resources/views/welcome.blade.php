<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Linsight</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container d-flex justify-content-center">
            {{-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home/'.  auth()->user()->id) }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}

            <div class="col-md-8 content-center" style="color:#326A78;font-size: 84px;padding-top:180px">
                <img style="width: 100%;height:auto" src="images/logo/logo1.png" alt="linsight logo">
                <div class="d-flex justify-content-center">
                    <div class="col-md-6" style="margin-top: -60px">
                        @auth
                            <a class="btn btn-lg btn-block btn-outline-primary" href="{{ url('/home/') }}">Return to Home</a>
                        @else
                            <a class="btn btn-lg btn-block btn-outline-primary" href="{{ route('login') }}">Get Started</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
