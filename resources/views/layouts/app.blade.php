<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="http://acmicpc.ntut.club/ACM_icon_square.png"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ACM BLOG') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- include summernote css -->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.css" rel="stylesheet">

</head>
<body>
    @include('layouts.buddha_blessing')
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'ACM BLOG') }}
                        Bata
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="/news">News</a></li>
                        <li><a href="/comprtition">Competition</a></li>
                        <li><a href="/community">Community</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @can('check_admin')
                                    <li>
                                        <a href="/console">console</a>
                                    </li>
                                    @endcan
                                    <li>
                                        <a href="/info">info</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.6/summernote.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
    if (Notification.permission != "denied") {Notification.requestPermission()};
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('a10576c26e2b056a17ca', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('newsroom');
        channel.bind("App\\Events\\ChatMessageWasReceived", function(data) {
            console.log(data);
            if (Notification.permission == "granted") {
                // 如果已經授權就可以直接新增 Notification 了!
                var notification = new Notification(data.chatMessage.message, {
                    body: '【news_' + data.chatMessage.type + '】' + data.user,
                    icon: 'http://acmicpc.ntut.club/ACM_icon_square.png'
                });
                notification.onclick = function() {
                    window.open(data.chatMessage.link);
                    notification.close();
                };
            }else if (Notification.permission != "denied") {
                Notification.requestPermission(function (permission) {
                    if (permission === "granted") {
                        var notification = new Notification(data.chatMessage.message, {
                            body: '【news_' + data.chatMessage.type + '】' + data.user,
                            icon: 'http://acmicpc.ntut.club/ACM_icon_square.png'
                        });
                        notification.onclick = function() {
                            window.open(data.chatMessage.link);
                            notification.close();
                        };
                    }
                });
            }
        });
    </script>
    @yield('script')

</body>
</html>
