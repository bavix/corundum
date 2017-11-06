<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>@yield('title') — {{ env('APP_NAME') }}</title>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

        <style>
            html, body, .wrapper {
                height: 100%;
            }

            .wrapper {
                padding: 1rem .3rem;
            }

            .wrapper-card {
                max-width: 400px;
                width: 100%;

                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2),
                0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }

            body {
                /*background: #76b852; !* fallback for old browsers *!*/
                /*background: -webkit-linear-gradient(right, #76b852, #8DC26F);*/
                /*background: -moz-linear-gradient(right, #76b852, #8DC26F);*/
                /*background: -o-linear-gradient(right, #76b852, #8DC26F);*/
                /*background: linear-gradient(to left, #76b852, #8DC26F);*/
                
                background: #6a5ebc; /* fallback for old browsers */
                background: -webkit-linear-gradient(right, #6a5ebc, #d2b494);
                background: -moz-linear-gradient(right, #6a5ebc, #d2b494);
                background: -o-linear-gradient(right, #6a5ebc, #d2b494);
                background: linear-gradient(to left, #6a5ebc, #d2b494);
            }
        </style>

    </head>
    <body>

        <div class="wrapper d-flex justify-content-center align-items-center">
            <div class="wrapper-card card">
                <div class="card-body">
                    <h1 class="card-title text-center">@yield('title')</h1>

                    @yield('form')
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>