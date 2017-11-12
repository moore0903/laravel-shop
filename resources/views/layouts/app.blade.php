<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>温特斯顿-超导强热石墨烯地暖</title>
    <link href="{{ asset('theme/css/style.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ asset('theme/common/jquery-1.7.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/jquery.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('theme/common/iader.js') }}"></script>
    <script type="text/javascript" src="http://validform.rjboy.cn/Validform/v5.1/Validform_v5.1_min.js"></script>
    <script type="text/javascript" src="{{ asset('packages/layer/layer.js') }}"></script>
</head>

<body>

<div class="wrap fmyh">
    <div class="topbar mod">
        <div class="logo"><a href="{{ url('/') }}"></a></div>
        <ul class="menu lifl">
            <li>
                <p class="name"><a href="{{ url('/') }}">首 页</a></p>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/1') }}">企业文化</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(1) as $catalog)
                        <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                </dl>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/4') }}">采暖市场</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(4) as $catalog)
                    <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                </dl>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/17') }}">科技之光</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(17) as $catalog)
                        <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                </dl>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/21') }}">财富站</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(21) as $catalog)
                        <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                </dl>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/25') }}">讯息台</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(25) as $catalog)
                        <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                </dl>
            </li>
            <li>
                <p class="name"><a href="{{ url('/catalog/29') }}">大本营</a></p>
                <dl class="clear">
                    @foreach(\App\Models\Catalog::parentCatalog(29) as $catalog)
                        <dd><a href="{{ url('/catalog/'.$catalog->id) }}">{{ $catalog->title }}</a></dd>
                    @endforeach
                        <dd><a href="{{ url('/message') }}">在线留言</a></dd>
                </dl>
            </li>
        </ul>
        <div class="clean"></div>
        <div class="vip"> <a href="{{ Auth::check() ? url('/user/info') : url('/login') }}">会员专区</a> </div>
    </div>
</div>

@yield('content')

<div class="fdm1 mod">
    <p class="fc1"></p>
    <div class="wrap clear">
        <dl class="fnav lifl fl">
            <dt>导航</dt>
            <dd><a href="{{ url('/catalog/9') }}">企业介绍</a></dd>
            <dd><a href="{{ url('/catalog/10') }}">企业精神</a></dd>
            <dd><a href="{{ url('/catalog/11') }}">企业实力</a></dd>
            <dd><a href="{{ url('/catalog/12') }}">企业荣誉</a></dd>
            <dd><a href="{{ url('/catalog/13') }}">企业规划</a></dd>
            <dd><a href="{{ url('/catalog/14') }}">企业风采</a></dd>
            <dd><a href="{{ url('/catalog/15') }}">知识产权</a></dd>
            <dd><a href="{{ url('/catalog/16') }}">企业事件</a></dd>
        </dl>
        <dl class="contatc fl">
            <dt>联系方式</dt>
            <dd>服务热线：</dd>
            <dd>400-1058-258</dd>
            <dd>地址：</dd>
            <dd>西安交通大学苏州科技园</dd>
        </dl>
        <div class="fphone fl">
            <p class="bt">全国咨询热线：</p>
            <p class="title">400-1058-258</p>
            <p class="fx">分享到：</p>
            <ul class="fxlist lifl clear">
                <li class="f1"><a href="#"></a></li>
                <li class="f2"><a href="#"></a></li>
            </ul>
        </div>
        <div class="fewm fr"></div>
    </div>
</div>
<div class="copyright fmyh">
    ALL Rights Reseved   苏ICP备16018689号-1  版权所有
</div>
<script type="text/javascript">
    function setNav(id){
        $("ul.menu li .name").children("a").eq(id-1).addClass("hover");
    }
</script>

@yield('script')

</body>
</html>
