<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AY KHEDMA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/assets/css/web.app.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
            window.App = {'locale' : '{{ app()->getLocale() }}'};
        </script>

    </head>

    <body>
        <!-- Start Nave -->
        @include('web.navbar')
        <!-- End Nave -->
        <div id="app">
            @yield('content')
        </div>

        <!-- Start Footer -->
        <footer>

            <div class="container">
                <div class="row">
                    <div class="col-lg-4 text-sm-center">
                        <img class="logolg" src="/assets/img/Icons/logo_larg.png">
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
        @routes
        <script src="/assets/js/web.app.js"></script>
    </body>

</html>
