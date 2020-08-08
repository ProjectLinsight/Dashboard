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
        {{-- <div class="container d-flex justify-content-center"> --}}
        <div class="container-fluid" style="display: table;position: absolute;top: 0;left: 0;height: 100%;width: 100%;">
            <div class=""  style="display: table-cell;vertical-align: middle;">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4 content-center" style="color:#326A78;font-size: 74px;">
                        <img style="width: 100%;height:auto" src="images/logo/logo1.png" alt="linsight logo">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-6" style="margin-top: -60px">
                                @auth
                                    @if (Auth::user()->utype=='Student')
                                    <a class="btn btn-block btn-outline-primary" href="{{ url('/home/') }}">Return to Home</a>
                                    @elseif (Auth::user()->utype=='Lecturer')
                                    <a class="btn btn-block btn-outline-primary" href="{{ url('/lecturer/lecturer_home/') }}">Return to Home</a>
                                    @elseif (Auth::user()->utype=='Admin')
                                    <a class="btn btn-block btn-outline-primary" href="{{ url('/admin/dashboard/') }}">Return to Home</a>
                                    @endif
                                @else
                                    <a class="btn btn-block btn-outline-primary" href="{{ route('login') }}">Get Started</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
