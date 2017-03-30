<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="all" />
    <link rel="start" href="" title="Home" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta id="viewport" name="viewport" content="width=750, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="HandheldFriendly" content="true"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/css/flexslider.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/jquery-1.7.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/jquery.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/ciads.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/tab.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/jquery.flexslider.js') }}"></script>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
<div class="wrap">
    @yield('header')

    @yield('banner')

    @yield('search')

    @yield('content')

    @yield('layouts.bottom_bar')

    <div class="fbottom"></div>
</div>
<div class="stop"><img src="{{ asset('theme/bg/stop.png') }}" width="85" /></div>
<script type="text/javascript">
    $(window).load(function(){
        $('.flexslider').flexslider({
            animation: "slide",
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    });
</script>
</body>
</html>