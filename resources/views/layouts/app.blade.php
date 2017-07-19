
<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="{{ asset('theme/common/jquery-1.7.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/tab.js') }}"></script>
    <meta name="robots" content="all" />
    <link rel="start" href="" title="Home" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta id="viewport" name="viewport" content="width=750, user-scalable=0">
    <meta name="HandheldFriendly" content="true"/>
    <title>武汉金土地后勤服务有限公司</title>
    <link href="/theme/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/theme/css/flexslider.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/js/vue.js"></script>
    <script type="text/javascript" src="/packages/layer/layer.js"></script>
</head>

<body>
<div class="wrap">
    @yield('header')

    @yield('banner')

    @yield('search')

    @yield('content')

    @yield('bottom_bar')

    <div class="fbottom"></div>
</div>
<div class="stop"><img src="/theme/bg/stop.png" width="85" /></div>
<script type="text/javascript" src="/theme/common/jquery.tools.min.js"></script>
<script type="text/javascript" src="/theme/common/ciads.js"></script>
<script type="text/javascript" src="/theme/common/jquery.flexslider.js"></script>
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