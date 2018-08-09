<!DOCTYPE html>
<html lang="{{ \app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/svg/logo.svg" class="logo" />
            </a>
            <button class="navbar-toggler" type="button"
                    data-toggle="collapse"
                    data-target="#navbar"
                    aria-controls="navbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main id="app" class="container">
        <div class="row">
            <div class="col-md-3">
                <bucket-menu v-bind:items="buckets"></bucket-menu>
            </div>
            <div class="col-md-3">
                <bucket-menu v-bind:items="buckets"></bucket-menu>
            </div>
            <div class="col-md-6">
                <bucket-menu v-bind:items="buckets"></bucket-menu>
            </div>
            {{--@yield('content')--}}
        </div>
    </main>

    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
