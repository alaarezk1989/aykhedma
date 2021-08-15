
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Splite-Admin Dashboard</title>

        <!--Favicon -->
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>

        <!--Style css-->
        <link rel="stylesheet" href="/assets/css/admin.app.css">

    </head>

    <body class="bg-primary">

        <!--app open-->
        <div id="app" class="page">
            <section class="section">
                <div class="container">
                    <div class="">

                        <!--single-page open-->
                        <div class="single-page">
                            <div class="">
                                <div class="wrapper wrapper2">
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                            <div class="alert-icon"><i class="ion ion-ios-lightbulb-outline"></i></div>
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>×</span>
                                                </button>
                                                <div class="alert-title">{{trans('error')}}</div>
                                                {{ session('error') }}
                                            </div>
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.auth.attempt') }}" method="post"  id="login" class="card-body" tabindex="500">
                                        @csrf
                                        <h3 class="text-dark">{{ trans('login') }}</h3>
                                        <div class="mail">
                                            <input type="text" name="email"class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                        </div>
                                        <div class="passwd">
                                            <input type="password" name="password"class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <p class="mb-3 text-right"><a href="forgot.html">Forgot Password</a></p>
                                        <div class="submit">
                                            <button type="submit"  class="btn btn-primary btn-block">{{trans('login')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--single-page closed-->

                    </div>
                </div>
            </section>
        </div>
        <!--app closed-->

        <!--Jquery.min js-->
        <script src="/assets/js/admin.app.js"></script>
    </body>
</html>