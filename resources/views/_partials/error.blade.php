<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"/>
    <link href="{{ asset('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css')  }}" rel="stylesheet"/>

    <style>
        html, body {height: 100%}
        #be-right-back {width: 260px}
        a.bavix:hover[href] {filter: contrast(150%)}
    </style>
</head>
<body>
<div class="d-flex" style="height: 100%; width: 100%;">
    <div id="be-right-back" class="mx-auto align-self-center">

        <a class="bavix" href="https://bavix.ru/" title="{{ __('bavix.description') }}">
            <img alt="{{ __('bavix.description') }}"
                 title="{{ __('bavix.description') }}"
                 width="100%" height="100%"
                 src="https://ds.bavix.ru/svg/logo.svg" />
        </a>

        @if (isset($reload))
            <div id="loaders">
                <div class="loader-container mx-auto arc-rotate-double">
                    <div class="loader">
                        <div class="arc-1"></div>
                        <div class="arc-2"></div>
                    </div>
                </div>
            </div>
        @endif

        <h6 class="text-center">{{ $title }}</h6>

        @if (isset($description))
            <p class="text-center text-muted">{{ $description }}</p>
        @endif

    </div>
</div>

@if (isset($reload))
    <link href="{{ asset('css/css-loader/index.css') }}" rel="stylesheet" />
    <script defer async>
        setInterval(function () {
            fetch('/', { method: 'HEAD' }).then(function (response) {
                if (199 < response.status && response.status < 300) {
                    location.reload();
                }
            });
        }, 2000);
    </script>
@endif

</body>
</html>
