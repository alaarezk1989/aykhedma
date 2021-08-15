<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ trans('dashboard') }}</title>

    <!--favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>

    <!--app.css css-->
    <link rel="stylesheet" href="{{ url('assets/css/admin.app.css') }}">

    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" href="{{ url('assets/css/admin.app.rtl.css') }}">
    @endif

</head>

<body class="app ">

<!--Header Style -->
<div class="wave -three"></div>

<!--loader -->
<div id="spinner"></div>

<!--app open-->
<div id="app" class="page">
    <div class="main-wrapper">

        <!--nav open-->
        <nav class="navbar navbar-expand-lg main-navbar">
            <a class="header-brand" href="{{ route('admin.home.index') }}">
                <img src="{{ url('assets/img/Icons/logo.png') }}" class="header-brand-img" alt="Splite-Admin  logo">
            </a>
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-2">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link toggle"><i class="fa fa-reorder"></i></a>
                    </li>
                    <li><a href="#" data-toggle="search" class="nav-link nav-link d-md-none navsearch"><i
                                class="fa fa-search"></i></a></li>
                </ul>
                {{--<div class="search-element mr-3">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <span class="Search-icon"><i class="fa fa-search"></i></span>
                </div>--}}
            </form>
            <ul class="navbar-nav nav bar-right">
                <li class="dropdown dropdown-list-toggle d-none d-lg-block ">
                    <a href="#" data-toggle="dropdown" class="nav-link  nav-link-lg "><i class=" fa fa-flag-o "></i></a>
                    <div class="dropdown-menu dropdown-menu-lg  dropdown-menu-right">

                        @foreach (Config::get('app.locales') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <a href="{{ route(Route::currentRouteName(), array_merge( request()->route()->parameters(), ['lang' => $lang])) }}"
                                   class="dropdown-item d-flex align-items-center">
                                    <div>
                                        <strong>{{$language}}</strong>
                                    </div>
                                </a>
                            @endif
                        @endforeach

                    </div>
                </li>

                <li class="dropdown dropdown-list-toggle d-none d-lg-block">
                    <a href="#" class="nav-link nav-link-lg full-screen-link">
                        <i class="fa fa-expand " id="fullscreen-button"></i>
                    </a>
                </li>
                <li class="dropdown"><a href="#" data-toggle="dropdown"
                                        class="nav-link dropdown-toggle nav-link-lg d-flex">
                                <span class="mr-3 mt-2 d-none d-lg-block ">
                                    <span class="text-white">{{trans('hello')}},<span
                                            class="ml-1">{{auth()->user()->first_name.' '.auth()->user()->last_name}}</span></span>
                                </span>
                        <span>
                                    <img src="{{ asset( auth()->user()->image) }}"
                                         alt="{{auth()->user()->first_name.' '.auth()->user()->last_name}}"
                                         class="rounded-circle w-32 mr-2">
                                </span>
                    </a>
                    <div class="dropdown-menu ">
                        {{--
                        <a class="dropdown-item" href="profile.html"><i class="mdi mdi-account-outline mr-2"></i><span>My profile</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-settings mr-2"></i><span>Settings</span></a>
                        <a class="dropdown-item" href="#"><i class=" mdi mdi-message-outline mr-2"></i> <span>Mails</span></a>
                        <a class="dropdown-item" href="#"><i class=" mdi mdi-account-multiple-outline mr-2"></i> <span>Friends</span></a>
                        <a class="dropdown-item" href="#"><i class="fe fe-calendar mr-2"></i> <span>Activity</span></a>
                        <a class="dropdown-item" href="#"><i class="mdi mdi-compass-outline mr-2"></i> <span>Support</span></a>
                        --}}
                        <a class="dropdown-item" href="{{ route('web.auth.logout') }}"><i
                                class="mdi  mdi-logout-variant mr-2"></i> <span>{{trans('logout')}}</span></a>
                    </div>
                </li>
            </ul>
        </nav>
        <!--nav closed-->

        <!--aside open-->

    @yield('sidebar', View::make('admin.sidebar'))
    <!--aside closed-->

    @yield('content')

    <!--Footer-->
        <footer class="main-footer">
            <div class="text-center">
                Copyright &copy;Lodex 2016. Design By<a href="http://www.lodex-solutions.com"> Lodex</a>
            </div>
        </footer>
        <!--/Footer-->

        <!-- Popupchat open-->
        <div class="popup-box chat-popup" id="qnimate">
            <div class="popup-head">
                <div class="popup-head-left pull-left"><img src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                                                            alt="iamgurdeeposahan" class="mr-2"> Alica Nestle
                </div>
                <div class="popup-head-right pull-right">
                    <div class="btn-group">
                        <button class="chat-header-button" data-toggle="dropdown" type="button" aria-expanded="false">
                            <i class="glyphicon glyphicon-cog"></i></button>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                            <li><a href="#">Media</a></li>
                            <li><a href="#">Block</a></li>
                            <li><a href="#">Clear Chat</a></li>
                            <li><a href="#">Email Chat</a></li>
                        </ul>
                    </div>
                    <button data-widget="remove" id="removeClass" class="chat-header-button pull-right" type="button"><i
                            class="glyphicon glyphicon-off"></i></button>
                </div>
            </div>
            <div class="popup-messages">
                <div class="direct-chat-messages">
                    <div class="chat-box-single-line">
                        <abbr class="timestamp">December 15th, 2018</abbr>
                    </div>
                    <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left">Alica Nestle</span>
                            <span class="direct-chat-timestamp float-right">7:40 Am</span>
                        </div>
                        <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                             alt="message user image">
                        <div class="direct-chat-text">
                            Hello. How are you today?
                        </div>
                    </div>
                    <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-right">Roberts</span>
                            <span class="direct-chat-timestamp float-left">8:05 Am</span>
                        </div>
                        <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-2.jpeg') }}"
                             alt="message user image">
                        <div class="direct-chat-text">
                            I'm fine. Thanks for asking!
                        </div>
                    </div>
                    <div class="chat-box-single-line  mb-3">
                        <abbr class="timestamp">December 14th, 2018</abbr>
                    </div>
                    <div class="direct-chat-msg doted-border">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name float-left">Alica Nestle</span>
                            <span class="direct-chat-timestamp float-right">6:20 Am</span>
                        </div>
                        <img alt="iamgurdeeposahan" src="{{ url('assets/img/avatar/avatar-3.jpeg') }}"
                             class="direct-chat-img"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            Hey bro, how’s everything going ?
                        </div>
                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name float-right">Roberts</span>
                                <span class="direct-chat-timestamp float-left">7:05 Am</span>
                            </div>
                            <img class="direct-chat-img" src="{{ url('assets/img/avatar/avatar-2.jpeg') }}"
                                 alt="message user image">
                            <div class="direct-chat-text">
                                Nothing Much!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-messages-footer">
                <textarea id="status_message" placeholder="Type a message..." rows="10" cols="40"
                          name="message"></textarea>
                <div class="btn-footer">
                    <button class="bg_none"><i class="glyphicon glyphicon-film"></i></button>
                    <button class="bg_none"><i class="glyphicon glyphicon-camera"></i></button>
                    <button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i></button>
                    <button class="bg_none pull-right"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                </div>
            </div>
        </div>
        <!-- Popupchat closed -->

    </div>
</div>
<!--app closed-->

<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!--Jquery.min js-->
<script src="{{ url('assets/js/admin.app.js') }}"></script>
@yield('scripts')
</body>
</html>
