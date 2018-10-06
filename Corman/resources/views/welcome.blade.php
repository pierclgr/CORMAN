<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CORMAN</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

            html, body {
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                background-image: url("{{asset('group_research.png')}}");
            }

            .full-height {
                height: 100vh;
            }

            .homeSX {
                align-items: left;
                display: flex;
                position: absolute;
                letter-spacing: .1rem;
                text-decoration: none;
                left: 90px;
                font-size: 50px;
            }

            .homeDX {
                align-items: right;
                display: flex;
                position: absolute;
                letter-spacing: .1rem;
                text-decoration: none;
                right: 30px;
                font-size: 50px;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .subtitle{
                font-size: 54px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div style="color: #f5f5f5;" class="flex-center position-ref full-height">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                            <a style="color: #f5f5f5;" href="{{ url('/home') }}"><b>Home</b></a>
                        @else
                            <a style="color: #f5f5f5;" href="{{ route('login') }}"><b>Login</b></a>
                            <a style="color: #f5f5f5;" href="{{ route('register') }}"><b>Register</b></a>
                        @endauth
                    </div>
                @endif
            <div class="content">
                <div class="title m-b-md">
                    <b>Welcome to CORMAN</b>
                </div>
                <div class="subtitle m-b-md">
                    <b>CORMAN lets you create research groups, publish papers and explore other user's researches</b>
                </div>
            </div>
        </div>
    </body>
</html>
