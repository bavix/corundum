<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.bavix.ru/bootstrap/next/dist/css/bootstrap.min.css" />

    <style>
        .bg-corundum {
            background: #628f5b;
        }

        main.container {
            padding-top: 1.4rem;
        }
    </style>

</head>
<body>

    <!-- Just an image -->
    <nav class="navbar navbar-expand-md navbar-dark bg-corundum">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{--<a class="navbar-brand" href="{{ route('ux.config.index') }}">--}}
                {{--<img src="https://ds.bavix.ru/svg/logo.svg" height="32" alt="Bavix" />--}}
            {{--</a>--}}
            
            <div class="collapse navbar-collapse" id="navbar">
                
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
{{--                        <a class="nav-link" href="{{ route('ux.config.index') }}">Home</a>--}}
                    </li>
                </ul>

                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout [{{ $user->email }}]
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>

            </div>

        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <link rel="stylesheet" href="https://cdn.bavix.ru/sweetalert2/latest/dist/sweetalert2.min.css" />

    <script src="https://cdn.bavix.ru/jquery/latest/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.bavix.ru/popper.js/1.12.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.bavix.ru/bootstrap/next/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.bavix.ru/sweetalert2/latest/dist/sweetalert2.min.js"></script>
</body>
</html>
